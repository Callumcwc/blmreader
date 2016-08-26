<?php

namespace ReneDeKat\Blm\Drivers;

use ReneDeKat\Blm\Reader;

class Simple extends Reader
{
    /**
     * Return the output as an array containing the keys: headers, definitions and data.
     *
     * @return array
     */
    public function getOutput()
    {
        return [
            'headers' => $this->getHeaders()->toArray(),
            'definitions' => $this->getDefinitions()->toArray(),
            'data' => $this->getData()->toArray(),
        ];
    }
}
