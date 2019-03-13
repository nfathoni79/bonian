<?php
namespace AdminPanel\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;

/**
 * GroupSale command.
 * @property \AdminPanel\Model\Table\ProductGroupsTable $ProductGroups
 * @property \AdminPanel\Model\Table\ProductGroupDetailsTable $ProductGroupDetails
 * @property \AdminPanel\Model\Table\CustomerCartDetailsTable $CustomerCartDetails
 */
class GroupSaleCommand extends Command
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.ProductGroups');
        $this->loadModel('AdminPanel.ProductGroupDetails');
        $this->loadModel('AdminPanel.CustomerCartDetails');
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
        $io->out("checking data group sale");

        $checkRunning = $this->ProductGroups->find()
            ->where(function (\Cake\Database\Expression\QueryExpression $exp) {
                return $exp->lte('date_end', (new \DateTime())->format('Y-m-d H:i:s'));
            })
            ->where([
                'status' => 1
            ])
            ->order(['id' => 'ASC'])
            ->first();
        if($checkRunning){
            $checkRunning->set('status', 2);
            if($this->ProductGroups->save($checkRunning)){
                $io->out("update table cart, session group sale expired");
                /* Find all Product ID*/
                $deals = $this->ProductGroupDetails->find()
                    ->where(['product_group_id' => $checkRunning->get('id')])
                    ->all();
                if($deals){
                    $listId = [];
                    foreach($deals as $k => $vals){
                        $listId[$k] = $vals['product_id'];
                    }
                    $query = $this->CustomerCartDetails->query();
                    $query->update()
                        ->set(['status' => 2])
                        ->where([
                            'product_id IN' => $listId,
                            'status' => 1,
                        ])
                        ->execute();
                }

            }
        }

        $checkWaiting = $this->ProductGroups->find()
            ->where(function (\Cake\Database\Expression\QueryExpression $exp) {
                return $exp->lte('date_start', (new \DateTime())->format('Y-m-d H:i:s'));
            })
            ->where([
                'status' => 0
            ])
            ->order(['id' => 'ASC'])
            ->first();

        if($checkWaiting){
            $checkWaiting->set('status', 1);
            if($this->ProductGroups->save($checkWaiting)){
                $io->out("update table cart, session flash sale start expired");
                /* Find all Product ID*/
                $deals = $this->ProductGroupDetails->find()
                    ->where(['product_deal_id' => $checkWaiting->get('id')])
                    ->all();
                if($deals){

                    $listId = [];
                    foreach($deals as $k => $vals){
                        $listId[$k] = $vals['product_id'];
                    }
                    $query = $this->CustomerCartDetails->query();
                    $query->update()
                        ->set(['status' => 2])
                        ->where([
                            'product_id IN' => $listId,
                            'status' => 1,
                        ])
                        ->execute();
                }

            }
        }
    }
}
