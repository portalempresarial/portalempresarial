<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PendingWholesalerDelivery;
use App\Models\CompanyProductStock;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessWholesalerDeliveries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-wholesaler-deliveries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process pending wholesaler deliveries and add products to company stock';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today();
        
        // Get all pending deliveries that are due today or earlier and not processed yet
        $pendingDeliveries = PendingWholesalerDelivery::where('delivery_date', '<=', $today)
            ->where('processed', false)
            ->with(['order.products', 'company'])
            ->get();
        
        $this->info("Found {$pendingDeliveries->count()} pending deliveries to process.");
        
        foreach ($pendingDeliveries as $delivery) {
            try {
                DB::beginTransaction();
                
                // Process all products in this order
                foreach ($delivery->order->orderProducts as $orderProduct) {
                    // Only process wholesaler products
                    if ($orderProduct->wholesaler_product_id) {
                        $wholesalerProduct = $orderProduct->wholesalerProduct;
                        
                        // Find the equivalent product in the company's catalog
                        // In a real system, we might need more complex matching logic
                        $matchingProduct = $delivery->company->products()
                            ->where('name', 'like', '%' . $wholesalerProduct->name . '%')
                            ->first();
                        
                        if ($matchingProduct) {
                            // Update existing stock
                            $stock = CompanyProductStock::firstOrNew([
                                'company_id' => $delivery->company_id,
                                'product_id' => $matchingProduct->id
                            ]);
                            
                            $stock->stock = ($stock->stock ?? 0) + $orderProduct->amount;
                            $stock->save();
                            
                            $this->info("Added {$orderProduct->amount} units of {$matchingProduct->name} to company {$delivery->company->name}");
                        } else {
                            $this->warn("No matching product found for {$wholesalerProduct->name} in company {$delivery->company->name}");
                        }
                    }
                }
                
                // Mark the delivery as processed
                $delivery->processed = true;
                $delivery->save();
                
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Error processing delivery ID {$delivery->id}: " . $e->getMessage());
                $this->error("Failed to process delivery ID {$delivery->id}: " . $e->getMessage());
            }
        }
        
        $this->info('Wholesaler deliveries processed successfully!');
        
        return Command::SUCCESS;
    }
}
