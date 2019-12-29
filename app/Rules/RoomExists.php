<?php

namespace App\Rules;

use App\Repositories\RESTStagRepository;
use Illuminate\Contracts\Validation\Rule;

class RoomExists implements Rule
{
    /**
     * @var string
     */
    protected $budilding;

    /**
     * @var RESTStagRepository
     */
    protected $stag;

    /**
     * Create a new rule instance.
     *
     * @param RESTStagRepository $stag
     * @param string $building
     */
    public function __construct(RESTStagRepository $stag, $building)
    {
        $this->budilding = $building;
        $this->stag = $stag;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->stag->roomExists($this->budilding, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Místnost neexistuje nebo se v ní neodehrávají žádné rozvrhové akce.';
    }
}
