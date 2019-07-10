<?php
namespace AdminPanel\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\I18n\Time;

/**
 * ExpiredCart command.
 * @property \AdminPanel\Model\Table\CustomerCartsTable $CustomerCarts
 * @property \AdminPanel\Model\Table\CustomerCartDetailsTable $CustomerCartDetails
 */
class ExpiredCartCommand extends Command
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.CustomerCarts');
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
        $io->out("checking data carts");

        $check = $this->CustomerCarts->find()
            ->where(function (\Cake\Database\Expression\QueryExpression $exp) {
                return $exp->lte('created', (Time::now())->addDays(-1)->format('Y-m-d H:i:s'));
            })
            ->where([
                'status' => 1
            ])
            ->all();
        if($check){

            $io->out("update cart detail");
            foreach($check as $vals){
                $cart = $vals;
                $cart['status'] = 2;
                if ($this->CustomerCarts->save($cart)) {
                    $query = $this->CustomerCartDetails->query();
                    $query->update()
                        ->set(['status' => 2])
                        ->where([
                            'customer_cart_id' => $vals['id'],
                        ])
                        ->execute();
                }
            }
        }

        $io->out("finish update data cart");
    }
}
