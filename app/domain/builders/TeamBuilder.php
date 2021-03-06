<?php
/**
 * Created by PhpStorm.
 * User: Miki
 * Date: 2/13/15
 * Time: 12:16 AM
 */

namespace MikiBrv\Domain\Builders;


use MikiBrv\Domain\Models\Team;
use MikiBrv\Domain\Specs\Team\Exceptions\InvalidTeamException;
use MikiBrv\Domain\Specs\Team\NameIsUnique;
use MikiBrv\Repositories\ITeamRepository;
use Validator;

class TeamBuilder implements IBuilder
{

    /**
     * @var Team
     */
    private $team;
    private $teamRepository;

    private function __construct(ITeamRepository $teamRepository)
    {
        $this->team = new Team();
        $this->teamRepository = $teamRepository;
    }

    /**
     * @param ITeamRepository $teamRepository
     * @return TeamBuilder
     */
    public static function create(ITeamRepository $teamRepository)
    {
        return new TeamBuilder($teamRepository);
    }

    public function validate()
    {
        $validator = Validator::make(
            array(
                'won' => $this->team->getWon(),
                'lost' => $this->team->getLost(),
                'draw' => $this->team->getDraw(),
                'name' => $this->team->getName()
            ),
            array(
                'won' => array('required', 'min:0'),
                'lost' => array('required', 'min:0'),
                'draw' => array('required', 'min:0'),
                'name' => array('required', 'min:2')
            )
        );
        if ($validator->fails()) {
            throw new InvalidTeamException();
        }
        $nameIsUnique = new NameIsUnique($this->teamRepository, $this->team->getName());
        if (!$nameIsUnique->apply()) {
            throw new InvalidTeamException();
        }
    }

    public function build()
    {
        $this->validate();
        return $this->team;
    }

    /**
     * @param $won
     * @return $this
     */
    public function addWon($won)
    {
        $this->team->setWon($won);
        return $this;
    }

    /**
     * @param $draw
     * @return $this
     */
    public function addDraw($draw)
    {
        if ($draw != null) {
            $this->team->setDraw($draw);
        }
        return $this;
    }


    /**
     * @param $lost
     * @return $this
     */
    public function addLost($lost)
    {
        if ($lost != null) {
            $this->team->setLost($lost);
        }
        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function name($name)
    {
        if ($name != null) {
            $this->team->setName($name);
        }
        return $this;
    }

    /**
     * @param $goalsFor
     * @return $this
     */
    public function goalsFor($goalsFor)
    {
        if ($goalsFor != null) {
            $this->team->setGoalsFor($goalsFor);
        }
        return $this;
    }


    /**
     * @param $goalsAgainst
     * @return $this
     */
    public function goalsAgainst($goalsAgainst)
    {
        if ($goalsAgainst != null) {
            $this->team->setGoalsAgainst($goalsAgainst);
        }
        return $this;
    }

    /**
     * @param \DateTime $lastPlayed
     * @return $this
     */
    public function lastPlayed(\DateTime $lastPlayed)
    {
        $this->team->setLastPlayed($lastPlayed);
        return $this;
    }

    /**
     * @param $location
     * @return $this
     */
    public function location($location)
    {
        $this->team->setLocation($location);
        return $this;
    }
}