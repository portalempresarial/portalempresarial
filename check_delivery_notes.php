<?php
require 'C:\\xampp\\htdocs\\vendor\\autoload.php';
require 'C:\\xampp\\htdocs\\bootstrap\\app.php';
app()->singleton('Illuminate\\Contracts\\Http\\Kernel', 'App\\Http\\Kernel');
app()->make(Illuminate\\Contracts\\Console\\Kernel::class)->bootstrap();

\ = App\Models\DeliveryNote::count();
\ = App\Models\DeliveryNote::whereNotNull('pdf_path')->count();

echo \
Total
delivery
notes:
\$total
\\n\;
echo \With
PDF
path:
\$withPdf
\\n\;

if (\ < \) {
    echo \Missing
PDF
paths:
\ . (\ - \) . \\\n\;
    \ = App\Models\DeliveryNote::whereNull('pdf_path')->get(['id', 'number']);
    foreach (\ as \) {
        echo \ID:
\$note->id
Number:
\$note->number
\\n\;
    }
}

