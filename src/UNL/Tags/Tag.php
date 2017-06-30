<?php
namespace UNL\Tags;

use JsonSerializable;

class Tag implements JsonSerializable
{
    private $machineName;
    private $humanName;
    private $description;
    private $children = [];
    
    static $usedMachineNames = [];
    
    function __construct($machineName, $humanName, $description = null)
    {
        $this->setMachineName($machineName);
        $this->setHumanName($humanName);
        $this->setDescription($description);
    }
    
    public function setMachineName($machineName)
    {
        $machineName = strtolower(trim(preg_replace('/[^A-Za-z0-9-_.]+/', '-', $machineName)));
        if (in_array($machineName, self::$usedMachineNames)) {
            throw new \UnexpectedValueException('The machine name '.$machineName.' is already used.');
        }
        
        self::$usedMachineNames[] = $machineName;
        
        $this->machineName = $machineName;
    }
    
    public function getMachineName()
    {
        return $this->machineName;
    }
    
    public function setHumanName($humanName)
    {
        $this->humanName = $humanName;
    }
    
    public function getHumanName() {
        return $this->humanName;
    }
    
    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    public function getDescription()
    {
        return $this->description;
    }
    
    public function addChild(Tag $child)
    {
        $this->children[] = $child;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        $data = [];
        $data['machine_name'] = $this->machineName;
        $data['human_name'] = $this->humanName;
        $data['description'] = $this->description;
        $data['children'] = $this->children;
        
        return $data;
    }
}
