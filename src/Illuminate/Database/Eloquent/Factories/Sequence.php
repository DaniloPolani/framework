<?php

namespace Illuminate\Database\Eloquent\Factories;

class Sequence
{
    /**
     * The sequence of return values.
     *
     * @var array
     */
    protected $sequence;

    /**
     * The count of the sequence items.
     *
     * @var int
     */
    protected $count;

    /**
     * The current index of the sequence.
     *
     * @var int
     */
    protected $index = 0;

    /**
     * Create a new sequence instance.
     *
     * @param  array  $sequence
     * @return void
     */
    public function __construct(...$sequence)
    {
        $this->sequence = $sequence;
        $this->count = count($sequence);
    }

    /**
     * Get the next value in the sequence.
     *
     * @return mixed
     */
    public function __invoke()
    {
        static $iteration = 1;

        if ($this->index > ($this->count - 1)) {
            $this->index = 0;
        }

        $currentSequence = $this->sequence[$this->index];
        $sequenceValue = is_callable($currentSequence) ? $currentSequence($iteration++) : $currentSequence;

        return tap($sequenceValue, function () {
            $this->index = $this->index + 1;
        });
    }
}
