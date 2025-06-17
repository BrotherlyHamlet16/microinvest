<php?
    protected function schedule(Schedule $schedule)
    {
    $schedule->command('investments:accrue-interest')->daily();
    }