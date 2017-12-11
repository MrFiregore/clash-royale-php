<?php
namespace CR\Objects;
use Illuminate\Support\Collection;



/**
 * Class BaseObject.
 */
abstract class BaseObject extends Collection
{
    /**
     * Builds collection entity.
     *
     * @param array|mixed $data
     */
    public function __construct($data)
    {
        parent::__construct($this->getRawResult($data));

        $this->mapRelatives();
    }

    /**
     * Property relations.
     *
     * @return array
     */
    abstract public function relations();

    /**
     * Get an item from the collection by key.
     *
     * @param mixed $key
     * @param mixed $default
     *
     * @return mixed|static
     */
    public function get($key, $default = null)
    {
        if ($this->offsetExists($key)) {
            return is_array($this->items[$key]) ? new static($this->items[$key]) : $this->items[$key];
        }

        return value($default);
    }

    /**
     * Map property relatives to appropriate objects.
     *
     * @return array|void
     */
    public function mapRelatives()
    {
        $relations = collect($this->relations());
        // d($this->relations(),$relations,get_class($this));
        if ($relations->isEmpty()) {
            return false;
        }


        return $this->items = collect($this->all())
            ->map(function ($value, $key) use ($relations) {
              // d($value, $key,$relations->has($key));

                if ($relations->has($key)) {
                    $className = $relations->get($key);

                    return new $className($value);
                }

                return $value;
            })
            ->all();
    }

    /**
     * Returns raw response.
     *
     * @return array|mixed
     */
    public function getRawResponse()
    {
        return $this->items;
    }

     /**
     * Returns raw result.
     * @method getRawResult
     * @param  [type]       $data [description]
     * @return mixed             [description]
     */
    public function getRawResult($data)
    {
        return array_get($data, 'result', $data);
    }

    /**
     * Get Status of request.
     *
     * @return mixed
     */
    public function getStatus()
    {
        return array_get($this->items, 'ok', false);
    }



     /**
     * Magic method to get properties dynamically.
     * @method __call
     * @param  string $name      [description]
     * @param  array $arguments [description]
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $action = substr($name, 0, 3);

        if ($action === 'get') {
            $property = camel_case(substr($name, 3));
            $response = $this->get($property);

            // Map relative property to an object
            $relations = $this->relations();
            if (null != $response && isset($relations[$property])) {
                return new $relations[$property]($response);
            }
            if (null == $response)return false;
            return $response;
        }

        return false;
    }
}
