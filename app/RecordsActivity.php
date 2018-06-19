<?php


namespace App;


trait RecordsActivity
{
    /**
     *Boots when model boots.
     */
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) return;

        foreach (self::getActivitiesToRecord() as $event)
        {
            static::$event(function ($thread) use ($event) {
                $thread->recordActivity($event);
            });
        }
    }

    /**
     * Returns events for listen when activity changed.
     *
     * @return array
     */
    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    /**
     * Creates a record in activity table.
     *
     * @param $event
     */
    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getEventType($event),

        ]);
    }

    /**
     * Generate event name for different types.
     *
     * @param $event
     * @return string
     */
    protected function getEventType($event)
    {
        $type = strtolower(class_basename($this));

        return "{$event}_{$type}";
    }

    /**
     * Polymorphic relationship.
     *
     * @return mixed
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}