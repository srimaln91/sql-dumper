<?php
namespace App\Lib;

use Pimple\Container;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class Config 
{

    protected $parsedConfig;

    public function __construct(Container $container, $fileName = 'config.yml')
    {

        $this->parseConfig($fileName);
    }

    private function parseConfig($fileName)
    {
        $configFilePath = __DIR__.'/../../config/'.$fileName;

        if (!file_exists($configFilePath)) {
            throw new \Exception('The config file does not exist!');
        }

        $this->parsedConfig = Yaml::parse(file_get_contents($configFilePath));
    }

    public function get($param = null)
    {
        if ($param != null){

            $data = $this->parsedConfig;
            $items = explode('.', $param);

            foreach ($items as $item){

                if (!array_key_exists($item, $data)){
                    return false;
                }

                $data = $data[$item];
            }

            return $data;
        }
        return $this->parsedConfig;
    }
}
