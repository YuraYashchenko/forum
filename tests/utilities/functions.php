<?php

/**
 * @param string $class
 * @param null $attributes
 * @param null $times
 * @return mixed
 */
function make(string $class, $attributes = null, $times = null)
{
    if ($attributes)
    {
        return factory($class, $times)->make($attributes);
    }

    return factory($class, $times)->make();
}

/**
 * @param string $class
 * @param null $attributes
 * @param null $times
 * @return mixed
 */
function create(string $class, $attributes = null, $times = null)
{
    if ($attributes)
    {
        return factory($class, $times)->create($attributes);
    }

    return factory($class, $times)->create();
}