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
     * Map property relatives to appropriate objects.
     *
     * @return array|void
     */
    public function mapRelatives()
    {
        $relations = collect($this->relations());

        if ($relations->isEmpty()) {
            return false;
        }


        return $this->items = collect($this->all())
            ->map(function ($value, $key) use ($relations) {

                if ($relations->has($key)) {
                    $className = $relations->get($key);
                    return (is_array($value) && array_keys($value) === range(0, count($value) - 1)) ? $value : new $className($value);
                }

                return $value;
            })
            ->all();
    }

    protected function recursiveMapRelatives($class, $data)
    {
      if (is_array($data) && array_keys($data) === range(0, count($data) - 1)) {
        $array = [];
        foreach ($data as $item) {
          $array[] = $this->recursiveMapRelatives($class, $item);
        }
        return $array;
      } else {
        return new $class($data);
      }
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
            $relations = $this->relations();

            if (null != $response && isset($relations[$property])) {
              return $this->recursiveMapRelatives($relations[$property],$response);
            }


            // Map relative property to an object
            if (null == $response) return false;
            return $response;
        }

        return false;
    }
}
