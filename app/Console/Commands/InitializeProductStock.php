<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\CompanyProductStock;
use Illuminate\Support\Facades\DB;

class InitializeProductStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:initialize-product-stock {--default-stock=10}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize stock for all existing products';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $defaultStock = (int)$this->option('default-stock');
        $this->info("Initializing product stock with default value: {$defaultStock}");
        
        // Get count of products that don't have stock entries
        $products = Product::all();
        $count = $products->count();
        
        if ($count === 0) {
            $this->info("No products found to initialize.");
            return Command::SUCCESS;
        }
        
        $this->info("Found {$count} products. Processing...");
        $bar = $this->output->createProgressBar($count);
        $bar->start();
        
        DB::beginTransaction();
        try {
            foreach ($products as $product) {
                // Update product stock
                $product->stock = $defaultStock;
                $product->save();
                
                // Create or update company product stock record
                CompanyProductStock::updateOrCreate(
                    [
                        'company_id' => $product->company_id,
                        'product_id' => $product->id
                    ],
                    [
                        'stock' => $defaultStock
                    ]
                );
                
                $bar->advance();
            }
            
            DB::commit();
            $bar->finish();
            $this->newLine();
            $this->info("Successfully initialized stock for all products!");
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("An error occurred: " . $e->getMessage());
            return Command::FAILURE;
        }
        
        return Command::SUCCESS;
    }
}
