<?php


namespace App\Traits;

trait RecordActivity
{
    protected static function bootRecordActivity()
    {
        if (auth()->guest()) {
            return;
        }
        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }

    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    public function activity()
    {
        return $this->morphMany(\App\Models\Activity::class, 'subject');
    }

    protected function getActivityType($event)
    {
        //$type = strtolower((new \ReflectionClass($this))->getShortName());
        $type = strtolower(class_basename($this));
        return "{$event}_{$type}";
    }
}
