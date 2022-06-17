 // public function addUsersToUnassigned()
    // {
    //     $difference = 0;
    //     $users_to_unassigned = DB::table('activities as a')
    //     ->select('u.name','p.project_Name','a.year','a.project_id','u.activity_status','u.supplier','a.month',DB::raw('SUM(a.task_hour) as sum'),'u.id')
    //     ->join('users as u','u.id','a.user_id')
    //     ->join('projects as p','p.id','a.project_id')
    //     ->where('a.year','=',2022)
    //     ->where('u.name','not LIKE','%ZZZ%')
    //     ->where('u.activity_status','NOT LIKE','%inact%')
    //     ->where('p.project_Name','Not Like','%unassigned%')
    //     ->where('a.month','>=',date('m'))
    //     ->groupBy('u.id','a.month')
    //     ->orderBy('u.name')
    //     ->get();

    //     foreach($users_to_unassigned as $user)
    //     {   
    //             if($user->sum < 17 )
    //         {

    //             $difference = 17 - $user->sum;
    //             print($user->sum."<br>");
    //             print($user->project_Name."<br>");
    //             print($user->project_id."<br>");
                
    //             print($user->name."<br>");
    //             print($difference."<br>");

    //             print($user->month."<br>");
    //             print($user->activity_status."<br>");
    //             print($user->supplier."<br>");



    //             $load_hours_to_unassigned = Activity::updateOrCreate([
    //                 'user_id'=>$user->id,
    //                 'project_id'=>801,
    //                 'month'=> $user->month,
    //                 'year'=>2022
    //             ],
    //             ['task_hour'=>$difference]
    //         );
                   
    //         }
    //         else{
    //             $load_hours_to_unassigned = Activity::updateOrCreate([
    //                 'user_id'=>$user->id,
    //                 'project_id'=>801,
    //                 'month'=> $user->month,
    //                 'year'=>2022
    //             ],
    //             ['task_hour'=>0]
    //         );   
    //         }
    //     }
    // }
