<?php
namespace AdminPanel\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\I18n\Time;

/**
 * ExpiredVoucher command.
 * @property \AdminPanel\Model\Table\CustomerVouchersTable $CustomerVouchers
 * @property \AdminPanel\Model\Table\VouchersTable $Vouchers
 */
class ExpiredVoucherCommand extends Command
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.CustomerVouchers');
        $this->loadModel('AdminPanel.Vouchers');
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
        $io->out("checking data customer voucher");

        $check = $this->CustomerVouchers->find()
            ->contain(['Vouchers'])
            ->where(function (\Cake\Database\Expression\QueryExpression $exp) {
                return $exp->lte('CustomerVouchers.expired', (Time::now())->format('Y-m-d H:i:s'));
            })
            ->where([
                'CustomerVouchers.status' => 1,
//                'Vouchers.type' => 1 // Filter hanya voucher dengan type 1. claim point
            ])
            ->all();

        if($check){
            foreach($check as $vals){
//                if($vals['voucher']['type'] == 1){
                    $query = $this->CustomerVouchers->query();
                    $query->update()
                        ->set(['status' => 3])
                        ->where([
                            'id' => $vals['id'],
                        ])
                        ->execute();
//                }else{
//
//                }
            }
        }

        $io->out("finish checking customer voucher");
    }
}
