<?php
/**
 * @link https://github.com/LAV45/yii2-activity-logger
 * @copyright Copyright (c) 2017 LAV45
 * @author Alexey Loban <lav451@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace lav45\activityLogger;

use yii\base\BaseObject;

/**
 * Class LogMessage this is a data transfer object
 * @package lav45\activityLogger
 *
 * @property string $data json data that was modified or relate to the subject
 */
class LogMessage extends BaseObject
{
    /**
     * @var string alias name target object
     */
    public $entityName;
    /**
     * @var string id target object
     */
    public $entityId;
    /**
     * @var int creation date of the action
     */
    public $createdAt;
    /**
     * @var string id user who performed the action
     */
    public $userId;
    /**
     * @var string user name who performed the action
     */
    public $userName;
    /**
     * @var string the action performed on the object
     */
    public $action;
    /**
     * @var string environment, which produced the effect
     */
    public $env;
    /**
     * @var mixed
     */
    private $data;
    /**
     * @var \Closure custom function for the encode `$data`
     */
    public $encode;

    /**
     * @return string|null
     */
    public function getData()
    {
        if (empty($this->data)) {
            return null;
        }
        return $this->encode($this->data);
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @param mixed $data
     * @return string
     */
    private function encode($data)
    {
        if (null === $this->encode) {
            return json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        return call_user_func($this->encode, $data);
    }
}
