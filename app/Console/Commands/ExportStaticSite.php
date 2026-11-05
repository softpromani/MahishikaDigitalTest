<?php

namespace App\Console\Commands;

use App\Http\Controllers\HomeController;
use Illuminate\Console\Command;

class ExportStaticSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'site:export-static';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export public Services landing page and mock API data to static files for Netlify / Vercel / GitHub Pages';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Exporting static HTML landing page...');

        $controller = new HomeController();
        $view = $controller->index();
        $html = $view->render();

        $html = str_replace('{{ csrf_token() }}', 'static-demo-token', $html);
        $html = str_replace('http://localhost/', './', $html);
        $html = str_replace('http://localhost', '.', $html);

        file_put_contents(public_path('index.html'), $html);
        $this->info('Saved public/index.html (' . strlen($html) . ' bytes).');

        // Also export static menu JSON
        $menuData = app(\App\Http\Controllers\ApiController::class)->menu()->getData();
        @mkdir(public_path('api'), 0755, true);
        file_put_contents(public_path('api/menu.json'), json_encode($menuData, JSON_PRETTY_PRINT));
        $this->info('Saved public/api/menu.json.');

        $this->info('Static export completed successfully!');

        return Command::SUCCESS;
    }
}

