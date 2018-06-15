<?php

/**
 * @param string $class
 * @param null $attributes
 * @return mixed
 */
function make(string $class, $attributes = null)
{
    if ($attributes)
    {
        return factory($class)->make($attributes);
    }

    return factory($class)->make();
}

/**
 * @param string $class
 * @param null $attributes
 * @return mixed
 */
function create(string $class, $attributes = null)
{
    if ($attributes)
    {
        return factory($class)->create($attributes);
    }

    return factory($class)->create();
}