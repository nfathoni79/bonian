<?php
namespace AdminPanel\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * PriceUpdateScheduleTask command.
 * @property \AdminPanel\Model\Table\ProductsTable $Products
 * @property \AdminPanel\Model\Table\ProductOptionPricesTable $ProductOptionPrices
 * @property \AdminPanel\Model\Table\PriceSettingsTable $PriceSettings
 * @property \AdminPanel\Model\Table\PriceSettingDetailsTable $PriceSettingDetails
 */
class PriceUpdateScheduleTaskCommand extends Command
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.Products');
        $this->loadModel('AdminPanel.ProductOptionPrices');
        $this->loadModel('AdminPanel.PriceSettings');
        $this->loadModel('AdminPanel.PriceSettingDetails');
    }
    /**
     * Hook method for defining this command's option parser.
     *
     * @see https://book.cakephp.org/3.0/en/console-and-shells/commands.html#defining-arguments-and-options
     *
     * @param \Cake\Console\ConsoleOptionParser $parser The parser to be defined
     * @return \Cake\Console\ConsoleOptionParser The built parser.
     */
    public function buildOptionParser(ConsoleOptionParser $parser)
    {
        $parser = parent::buildOptionParser($parser);

        return $parser;
    }

    /**
     * Implement this method with your command's logic.
     *
     * @param \Cake\Console\Arguments $args The command arguments.
     * @param \Cake\Console\ConsoleIo $io The console io
     * @return null|int The exit code or null for success
     */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $io->out("checking data price settings");

        $check = $this->PriceSettings->find()
            ->where(function (\Cake\Database\Expression\QueryExpression $exp) {
                return $exp->gte('schedule', (new \DateTime())->format('Y-m-d'));
            })
            ->where([
                'status' => 0
            ])
            ->first();

        if ($check) {
            $check->set('status', 1);
            if ($this->PriceSettings->save($check)) {
                $io->out('successfully price settings');

                $io->out("checking data price setting details");

                $checkDetails = $this->PriceSettingDetails->find()
                    ->where([
                        'price_setting_id' => $check->get('id'),
                        'status' => 0
                    ])
                    ->all();

                foreach($checkDetails as $vals){
                    switch (strtolower($vals['type'])) {
                        case 'main':
                            $findProduct =  $this->Products->find()
                                ->where([
                                    'sku' => $vals['sku'],
                                ])
                                ->first();
                            if($findProduct){
                                $findProduct->set('price_sale', $vals['price']);
                                if($this->Products->save($findProduct)){
                                    $query = $this->PriceSettingDetails->query();
                                    $query->update()
                                        ->set(['status' => 1])
                                        ->where([
                                            'sku' => $vals['sku'],
                                            'status' => 0,
                                            'type' => 'Main'
                                        ])
                                        ->execute();
                                    $io->out("SKU main ".$vals['sku']." updated price");
                                }
                            }
                        break;
                        case 'variant':
                            $findProductOptionPrice =  $this->ProductOptionPrices->find()
                                ->where([
                                    'sku' => $vals['sku'],
                                ])
                                ->first();
                            if($findProductOptionPrice){
                                $findProductOptionPrice->set('price', $vals['price']);
                                if($this->ProductOptionPrices->save($findProductOptionPrice)){
                                    $query = $this->PriceSettingDetails->query();
                                    $query->update()
                                        ->set(['status' => 1])
                                        ->where([
                                            'sku' => $vals['sku'],
                                            'status' => 0,
                                            'type' => 'Variant'
                                        ])
                                        ->execute();
                                    $io->out("SKU variant ".$vals['sku']." updated price");
                                }
                            }

                        break;
                    }
                }

            }
        }
        $io->out("finished checking data price setting");
    }
}
