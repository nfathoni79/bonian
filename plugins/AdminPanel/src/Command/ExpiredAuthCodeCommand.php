<?php
namespace AdminPanel\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\I18n\Time;

/**
 * ExpiredAuthCode command.
 * @property \AdminPanel\Model\Table\AuthCodesTable $AuthCodes
 */
class ExpiredAuthCodeCommand extends Command
{

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('AdminPanel.AuthCodes');
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

        $io->out("checking data auth codes");

        $check = $this->AuthCodes->find()
            ->where(function (\Cake\Database\Expression\QueryExpression $exp) {
                return $exp->lte('expired', (Time::now())->format('Y-m-d H:i:s'));
            })
            ->where(['used' => 0])
            ->all();
        if($check){
            foreach($check as $vals){
                $query = $this->AuthCodes->query();
                $query->update()
                    ->set(['used' => 2])
                    ->where([
                        'id' => $vals['id'],
                    ])
                    ->execute();
            }
        }

        $io->out("finish checking auth codes");

    }
}
