<?php declare(strict_types=1);

/*
 * This file is part of Zafkiel.
 *
 * (c) Kévin BENTO <kevin.bento@free.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zafkiel\Mapper;

require(__DIR__ . '/Mapper.php');
require(__DIR__ . '/../TransferObject.php');

use Zafkiel\TransferObject;

/**
 * Mapper for Zafkiel, designed for specific parsing returned by Zafkiel\Parser
 * @see Zafkiel\Parser
 * 
 * @package Zafkiel-Core
 * @since v0.1.0
 * @author BENTO Kévin (kevin.bento@free.fr)
 *
 * @link https://github.com/kevin10-26/Zafkiel-Core
 */

class ObjectMapper implements Mapper
{
    private ?TransferObject $_data = null;
    private array $_input          = array();
    private string $_module        = "";

    /**
     * @since v0.1.0
     * @see Zafkiel\TransferObject
     * 
     * @param array $data {
     *      @type string $key module : specifies the module
     *      @type array $key data {} : the data inside, which will be parsed
     * }
     * 
     * @return void;
     */

    public function __construct(Array $input, string $module) {
        $this->_data   = new TransferObject();
        $this->_input  = $input;
        $this->_module = $module;
    }

   /**
     * Maps an input to set it via the DTO, make it readable to work with modules.
     * @see Zafkiel\TransferObject class
     * 
     * @since v0.1.0
     * 
     * @param string $mode : used to parse the string according to its source : json / classic array, into an array recognized by the class.
     * 
     * @return ObjectMapper : should be called with getMappedData() method of the same class.
     */
    public function mapData() : ObjectMapper
    {
        $body = $this->_buildData();

        $this->_data->setBody($body);

        return $this;
    }

    final public function getMappedData() : TransferObject
    {
        return $this->_data;
    }

    private function _buildData()
    {
        return array(
            'module' => $this->_module,
            'data'   => $this->_input
        );
    }
}