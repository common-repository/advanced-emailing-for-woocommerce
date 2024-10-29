<?php

namespace rnadvanceemailingwc\TwigManager\Renderers\Blocks;

use rnadvanceemailingwc\DTO\ProductTableBlockOptionsDTO;
use rnadvanceemailingwc\TwigManager\Renderers\Blocks\Core\BlockRendererBase;
use rnadvanceemailingwc\TwigManager\TextRenderer\DocumentTextRenderer;
use Twig\Markup;

class ProductTableBlockRenderer extends BlockRendererBase
{
    /** @var ProductTableBlockOptionsDTO */
    public $Options;
    /** @var DocumentTextRenderer */
    public $Document;
    public $Headers;
    public $SubTotals;
    public $Rows;
    public $Style='';

    protected function GetTemplateName()
    {
        return 'TwigManager/Renderers/Blocks/ProductTableBlockRenderer.twig';
    }

    protected function InternalInitialize()
    {
        $this->Style=$this->Options->Style;
        parent::InternalInitialize();
        $this->CreateItems();
    }


    public function GetAdditionalClasses()
    {
        return 'PDFProductTable';
    }


    public function CreateItems(){
        $this->CreateHeaders();
        $this->CreateOrderItems();
        $this->CreateSubTotals();
    }

    private function CreateHeaders()
    {
        $this->Headers=[];
        foreach($this->Options->Columns as $currentColumn)
        {
            $this->Headers[]=(new DocumentTextRenderer($currentColumn->Header,$this))->Initialize()->Render();
        }
    }

    private function CreateOrderItems()
    {
        $itemsToUse=[];
        foreach ($this->GetRetriever()->Order->GetItems() as $currentItem)
        {
            $this->GetEmailRenderer()->OrderRetriever->SetCurrentOrderLine($currentItem);
            $rows=[];
            foreach($this->Options->Columns as $currentColumn)
            {
                $rows[]=(new DocumentTextRenderer($currentColumn->Content,$this))->Initialize()->Render();
            }

            $itemsToUse[]=$rows;
        }

        $this->GetEmailRenderer()->OrderRetriever->SetCurrentOrderLine(null);
        $this->Items=$itemsToUse;
    }


    public function GetSubTotalSpan()
    {
        return count($this->Options->Columns)-1;
    }

    private function CreateSubTotals()
    {
        $this->SubTotals=[];
        $subTotals=$this->GetRetriever()->Order->GetOrderItemTotals();
        foreach($this->Options->SubTotalRows as $subTotalItem)
        {
            $propertyName='';
            $processed=false;
            switch ($subTotalItem->SubTotalType)
            {
                case 'Subtotal':
                    $propertyName='cart_subtotal';
                    break;
                case 'Shipping':
                    $propertyName='shipping';
                    break;
                case 'PaymentMethod':
                    $propertyName='payment_method';
                    break;
                case 'Total':
                    $propertyName='order_total';
                    break;
                case 'Refunds':
                    $processed=true;
                    $this->SubTotals=array_merge($this->SubTotals,$this->CalculateRefundRows());
                    break;
                case 'Tax':
                    $processed=true;
                    $this->SubTotals=array_merge($this->SubTotals,$this->CalculateTaxes());

            }

            if($processed)
                continue;

            $value='';
            if(isset($subTotals[$propertyName]))
                $value=$subTotals[$propertyName]['value'];

            if($value=='')
            {
                if ($propertyName == 'payment_method')

                    continue;
                else
                    $value = wc_price(0);
            }

            $type=$subTotalItem->SubTotalType;
            $this->GetRetriever()->AddMeta('SubTotalType',$type);
            $this->SubTotals[]=[
                "Label"=>(new DocumentTextRenderer($subTotalItem->Label,$this,(Object)[
                    'SubTotalType'=>$type
                ]))->Initialize()->Render(),
                "Content"=>(new DocumentTextRenderer($subTotalItem->Content,$this,(Object)[
                    'SubTotalType'=>$type,
                    'SubTotalValue'=>$value
                ]))->Initialize()->Render()
            ];
        }

        $this->GetRetriever()->RemoveMeta('SubTotalType');


    }

    private function CalculateRefundRows()
    {
        if($this->GetRetriever()->IsTest)
            return [];
        $refunds=$this->GetRetriever()->GetWCOrder()->get_refunds();
        $refundList=[];

        foreach($refunds as $refund)
        {
            $refundList[]=[
                "Label"=>new Markup('<p style="text-align: left"><span  style="">'.esc_html($refund->get_reason() ? $refund->get_reason() : __( 'Refund', 'woocommerce' )).':</span></p>','UTF-8'),
                "Content"=>new Markup(wc_price( '-' . $refund->get_amount(), array( 'currency' => $this->GetRetriever()->Order->GetCurrency() ) ),'UTF-8')
            ];
        }

        return $refundList;
    }

    private function CalculateTaxes()
    {
        if($this->GetRetriever()->IsTest)
            return [];
        $taxes=$this->GetRetriever()->Order->GetTaxTotals();
        $taxList=[];

        foreach($taxes as $currentTax)
        {
            $taxList[]=[
                "Label"=>new Markup('<p style="text-align: left"><span  style="">'.esc_html($currentTax->label).':</span></p>','UTF-8'),
                "Content"=>new Markup($currentTax->formatted_amount,'UTF-8')
            ];
        }

        return $taxList;
    }


}