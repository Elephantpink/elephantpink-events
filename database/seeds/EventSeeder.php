<?php

use Illuminate\Database\Seeder;
use EPink\Events\Models\Event;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $first_event_date = Carbon::now();
        $first_event_date = $first_event_date->addMonth();
        $first_event_date = $first_event_date->setUnitNoOverflow('hour', 13, 'day');
        $first_event_date = $first_event_date->setUnitNoOverflow('minute', 00, 'hour');
        $first_event_date = $first_event_date->setUnitNoOverflow('second', 00, 'minute');

        Event::create([
            'name' => 'Conference',
            'location' => 'Marbella',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod 
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, 
                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            'date' => $first_event_date
        ]);

        $second_event_date = Carbon::now();
        $second_event_date = $second_event_date->addMonth();
        $second_event_date = $second_event_date->setUnitNoOverflow('hour', 18, 'day');
        $second_event_date = $second_event_date->setUnitNoOverflow('minute', 15, 'hour');
        $second_event_date = $second_event_date->setUnitNoOverflow('second', 00, 'minute');

        Event::create([
            'name' => 'Meet & Greet',
            'location' => 'Málaga',
            'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.',
            'date' => $second_event_date
        ]);

        $third_event_date = Carbon::now();
        $third_event_date = $third_event_date->addYear();
        $third_event_date = $third_event_date->addMonths(2);
        $third_event_date = $third_event_date->addWeek();
        $third_event_date = $third_event_date->setUnitNoOverflow('hour', 12, 'day');
        $third_event_date = $third_event_date->setUnitNoOverflow('minute', 30, 'hour');
        $third_event_date = $third_event_date->setUnitNoOverflow('second', 00, 'minute');

        Event::create([
            'name' => 'Company Dinner',
            'location' => 'Marbella',
            'description' => 'Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?',
            'date' => $third_event_date
        ]);


        $fourth_event_date = Carbon::now();
        $fourth_event_date = $fourth_event_date->subYear();
        $fourth_event_date = $fourth_event_date->setUnitNoOverflow('hour', 18, 'day');
        $fourth_event_date = $fourth_event_date->setUnitNoOverflow('minute', 00, 'hour');
        $fourth_event_date = $fourth_event_date->setUnitNoOverflow('second', 00, 'minute');

        Event::create([
            'name' => 'Company Dinner',
            'location' => 'Marbella',
            'description' => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga.',
            'date' => $fourth_event_date
        ]);
    }
}
