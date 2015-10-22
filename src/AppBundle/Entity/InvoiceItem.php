<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="invoice_item")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class InvoiceItem
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * Bidirectional - Many items/products may be referenced by an invoice
     *
     * @ORM\ManyToOne(targetEntity="Invoice", inversedBy="items")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $invoice;

    /**
     * Uniderecional
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $totalPrice;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return InvoiceItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set totalPrice
     *
     * @param string $totalPrice
     *
     * @return InvoiceItem
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get totalPrice
     *
     * @return string
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Set invoice
     *
     * @param \AppBundle\Entity\Invoice $invoice
     *
     * @return InvoiceItem
     */
    public function setInvoice(Invoice $invoice)
    {
        $this->invoice = $invoice;

        return $this;
    }

    /**
     * Get invoice
     *
     * @return \AppBundle\Entity\Invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * Set product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return InvoiceItem
     */

    public function setProduct(Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Since the main "target" is a product as item from invoice,
     * make a lot sense to return the name of product. Don't you?
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getProduct()->getName();
    }

    /**
     * @return string
     */
    public function calculateTotalPrice()
    {
        return $this->getProduct()->getPrice() * $this->getQuantity();
    }

    /**
     * Automatically defines the total price for this item.
     * It's just like as supposed calc: (Units * Unit price).
     * We could to save the price total value from form field but
     * it's not nice at all (Fraudulent transaction, may be?).
     *
     * @todo Add the same routine on @ORM\PreUpdate event.
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->setTotalPrice($this->calculateTotalPrice());
    }
}
