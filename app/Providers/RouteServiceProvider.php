public function map(): void
{
$this->mapApiRoutes();
$this->mapWebRoutes();

// Добавить в конец
$this->mapMediaRoutes();
}

protected function mapMediaRoutes(): void
{
Route::middleware('web')
->namespace($this->namespace)
->group(base_path('Modules/Media/routes/web.php'));
}