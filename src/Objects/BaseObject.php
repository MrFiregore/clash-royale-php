<?php
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 ~                                                                                                                                                                                                                                                          ~
 ~ Copyright (c) 2018 by firegore (https://firegore.es) (git:firegore2)                                                                                                                                                                                     ~
 ~ This file is part of clash-royale-php.                                                                                                                                                                                                                   ~
 ~                                                                                                                                                                                                                                                          ~
 ~ clash-royale-php is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 ~ clash-royale-php is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                                                                  ~
 ~ See the GNU Affero General Public License for more details.                                                                                                                                                                                              ~
 ~ You should have received a copy of the GNU General Public License along with clash-royale-php.                                                                                                                                                           ~
 ~ If not, see <http://www.gnu.org/licenses/> 2018.05.31                                                                                                                                                                                                    ~
 ~                                                                                                                                                                                                                                                          ~
 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/

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
     *  Unique identifier
     *
     * @return string
     */

    abstract public function primaryKey();



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
                return $this->recursiveMapRelatives($relations[$property], $response);
            }


            // Map relative property to an object
            if (null == $response) {
                return false;
            }
            return $response;
        }

        return false;
    }
}
