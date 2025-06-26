<?php
class DeliveryTimeOptions {
    private $interval;
    private $cutoffweekday;
    private $cutoffweekend;

    public function __construct($interval = 15, $cutoffweekday = 22, $cutoffweekend = 23) {
        $this->interval = $interval;
        $this->cutoffweekday = $cutoffweekday;
        $this->cutoffweekend = $cutoffweekend;
    }

    public function generate(): array {
    $options = [];
    $now = new DateTime('now', new DateTimeZone('Europe/Amsterdam'));
    $dayOfWeek = $now->format('N');

    $cutoffHour = ($dayOfWeek >= 6) ? $this->cutoffweekend : $this->cutoffweekday;
    $cutoffTime = (clone $now)->setTime($cutoffHour, 0);

    $start = clone $now;
    $start->add(new DateInterval('PT45M'));

    $minutes = (int) $start->format('i');
    $overflow = $this->interval - ($minutes % $this->interval);
    if ($overflow !== $this->interval) {
        $start->add(new DateInterval("PT{$overflow}M"));
    }

    while ($start < $cutoffTime) {
        $options[] = $start->format('H:i');
        $start->add(new DateInterval("PT{$this->interval}M"));
    }

    return array_merge(['Zo snel mogelijk'], $options);
}


}
