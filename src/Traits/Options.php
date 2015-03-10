<?php
/**
 * Created by PhpStorm.
 * User: MDJ
 * Date: 10.03.15.
 * Time: 07:10
 */

namespace Bridge\Traits;

trait Options
{
    public function setOptions(array $options)
    {
        return $this->options = array_merge($this->options, $options);
    }

    public function addOptions($var, $val = null)
    {
        if (is_string($var) && !$val) {
            throw new \InvalidArgumentException('Failed to add option. Option name provided without value');
        } elseif ($val) {
            $this->options[$var] = $val;
        } elseif (is_array($var)) {
            foreach ($var as $key => $val) {
                if (is_numeric($key)) {
                    throw new \InvalidArgumentException(
                        'Failed to add option. Array options must be in name => value format!'
                    );
                }

                $this->options[$key] = $val;
            }
        }

        return $this->options;
    }

    public function getOption($var = null)
    {
        if ($var) {
            if (isset($this->options[$var])) {
                return $this->options[$var];
            }
            throw new \InvalidArgumentException(sprintf("Unable to get option %s. Option doesn't exists", $var));
        }

        return $this->options;
    }
}