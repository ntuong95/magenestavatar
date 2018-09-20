<?php
/**
 * Created by PhpStorm.
 * User: tuong-linux
 * Date: 20/09/2018
 * Time: 14:49
 */
namespace Magenest\Avatar\Block\Account\Dashboard;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Customer\Api\Data\AddressInterface;
use Magento\Customer\Model\Address\Mapper;

class Custom extends \Magento\Framework\View\Element\Template{
    protected $currentCustomer;
    protected $currentCustomerAddress;
    protected $_helperView;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Helper\Session\CurrentCustomer $currentCustomer,
        \Magento\Customer\Helper\Session\CurrentCustomerAddress $currentCustomerAddress,
        \Magento\Customer\Helper\View $helperView,
        array $data = []
    ) {
        $this->currentCustomer = $currentCustomer;
        $this->currentCustomerAddress = $currentCustomerAddress;
        $this->_helperView = $helperView;
        parent::__construct($context, $data);
    }

    public function getAvatar()
    {
        $obm = \Magento\Framework\App\ObjectManager::getInstance();

        $customerSession = $obm->get('Magento\Customer\Model\Session');

        $prefix = '/magento/pub/media/customer';
        return $prefix.$customerSession->getCustomer()->getavatar_custom();

    }

    public function getPhoneNumber()
    {
        $phone = $this->currentCustomerAddress->getDefaultBillingAddress()->getTelephone();
        return $phone;
    }

    public function getCustomer()
    {
        try {
            return $this->currentCustomer->getCustomer();
        } catch (NoSuchEntityException $e) {
            return null;
        }
    }

    public function getName()
    {
        return $this->_helperView->getCustomerName($this->getCustomer());
    }

}