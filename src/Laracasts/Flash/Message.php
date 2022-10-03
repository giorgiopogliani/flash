<?php

namespace Laracasts\Flash;

class Message implements \ArrayAccess
{
    /**
     * The title of the message.
     *
     * @var string
     */
    public $title;

    /**
     * The body of the message.
     *
     * @var string
     */
    public $message;

    /**
     * The message level.
     *
     * @var string
     */
    public $level = 'info';

    /**
     * Whether the message should auto-hide.
     *
     * @var bool
     */
    public $important = false;

    /**
     * Whether the message is an overlay.
     *
     * @var bool
     */
    public $overlay = false;

    /**
     * Custom attributes to configure.
     *
     * @var array
     */
    public $attributes = [];

    /**
     * Create a new message instance.
     *
     * @param array $attributes
     */
    public function __construct($attributes = [])
    {
        $this->update($attributes);
    }

    /**
     * Update the attributes.
     *
     * @param  array $attributes
     * @return $this
     */
    public function update($attributes = [])
    {
        $attributes = array_filter($attributes);

        foreach ($attributes as $key => $attribute) {
            if (property_exists($this, $key)) {
                $this->$key = $attribute;
            } else {
                $this->attributes[$key] = $attribute;
            }
        }

        return $this;
    }


    /**
     * Whether the given offset exists.
     *
     * @param  mixed $offset
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }

    /**
     * Fetch the offset.
     *
     * @param  mixed $offset
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        if (property_exists($this, $offset)) {
            return $this->$offset;
        }

        return $this->attributes[$offset] ?? null;
    }

    /**
     * Assign the offset.
     *
     * @param  mixed $offset
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        if (property_exists($this, $offset)) {
            $this->$offset = $value;
        }

        $this->$attributes[$offset] = $value;
    }

    /**
     * Unset the offset.
     *
     * @param  mixed $offset
     * @return void
     */
    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        //
    }
}
