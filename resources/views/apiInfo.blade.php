@extends('layouts.app')

@section('title', 'API information')


@section('content')


    <p class="center diep-title">API</p>

    <p class="lead">If you want to get the current world records from this site to use it on a bot or similiar, there is no need to try to parse the page.
    The output from all the following api should be parsed as JSON.</p>


    <p class="h3">Getting the current world records</p>

    <p>Call a GET request <a href="{{route('apirecords')}}/json">here</a>.</p>
    <p>Example output (The records are <strong>grouped by tank_id</strong> and sorted by gamemode):</p>
    <!-- HTML generated using hilite.me -->
    <!-- HTML generated using hilite.me --><div style="background: #f8f8f8; overflow:auto;width:auto;border:solid gray;border-width:.1em .1em .1em .8em;padding:.2em .6em;margin-bottom:5em;"><pre style="margin: 0; line-height: 125%">{
   <span style="color: #008000; font-weight: bold">&quot;desktop&quot;</span>:{
      <span style="color: #008000; font-weight: bold">&quot;2&quot;</span>:[
         {
            <span style="color: #008000; font-weight: bold">&quot;record_id&quot;</span>:<span style="color: #666666">4</span>,
            <span style="color: #008000; font-weight: bold">&quot;name&quot;</span>:<span style="color: #BA2121">&quot;MasterOv Desktop&quot;</span>,
            <span style="color: #008000; font-weight: bold">&quot;score&quot;</span>:<span style="color: #BA2121">&quot;100.00K&quot;</span>,
            <span style="color: #008000; font-weight: bold">&quot;tank_id&quot;</span>:<span style="color: #666666">2</span>,
            <span style="color: #008000; font-weight: bold">&quot;tankname&quot;</span>:<span style="color: #BA2121">&quot;Annihilator&quot;</span>,
            <span style="color: #008000; font-weight: bold">&quot;tank_enabled&quot;</span>:<span style="color: #666666">1</span>,
            <span style="color: #008000; font-weight: bold">&quot;gamemode_id&quot;</span>:<span style="color: #666666">3</span>,
            <span style="color: #008000; font-weight: bold">&quot;gamemode&quot;</span>:<span style="color: #BA2121">&quot;FFA&quot;</span>,
            <span style="color: #008000; font-weight: bold">&quot;mobile&quot;</span>:<span style="color: #666666">0</span>,
            <span style="color: #008000; font-weight: bold">&quot;approvername&quot;</span>:<span style="color: #BA2121">&quot;admin&quot;</span>,
            <span style="color: #008000; font-weight: bold">&quot;submittedlink&quot;</span>:<span style="color: #BA2121">&quot;https:\/\/i.imgur.com\/zmEu90q.png&quot;</span>,
            <span style="color: #008000; font-weight: bold">&quot;approvedDate&quot;</span>:<span style="color: #BA2121">&quot;2016-11-18 08:44:47&quot;</span>,
            <span style="color: #008000; font-weight: bold">&quot;scorefull&quot;</span>:<span style="color: #666666">100000</span>,
            <span style="color: #008000; font-weight: bold">&quot;links&quot;</span>:[
               <span style="color: #BA2121">&quot;https:\/\/i.imgur.com\/zmEu90q.png&quot;</span>
            ]
         }
      ]
   },
   <span style="color: #008000; font-weight: bold">&quot;mobile&quot;</span>:{
      <span style="color: #008000; font-weight: bold">&quot;3&quot;</span>:[
         {
            <span style="color: #008000; font-weight: bold">&quot;record_id&quot;</span>:<span style="color: #666666">5</span>,
            <span style="color: #008000; font-weight: bold">&quot;name&quot;</span>:<span style="color: #BA2121">&quot;MasterOv Mobile&quot;</span>,
            <span style="color: #008000; font-weight: bold">&quot;score&quot;</span>:<span style="color: #BA2121">&quot;124.12K&quot;</span>,
            <span style="color: #008000; font-weight: bold">&quot;tank_id&quot;</span>:<span style="color: #666666">3</span>,
            <span style="color: #008000; font-weight: bold">&quot;tankname&quot;</span>:<span style="color: #BA2121">&quot;Assassin&quot;</span>,
            <span style="color: #008000; font-weight: bold">&quot;tank_enabled&quot;</span>:<span style="color: #666666">1</span>,
            <span style="color: #008000; font-weight: bold">&quot;gamemode_id&quot;</span>:<span style="color: #666666">1</span>,
            <span style="color: #008000; font-weight: bold">&quot;gamemode&quot;</span>:<span style="color: #BA2121">&quot;FFA&quot;</span>,
            <span style="color: #008000; font-weight: bold">&quot;mobile&quot;</span>:<span style="color: #666666">1</span>,
            <span style="color: #008000; font-weight: bold">&quot;approvername&quot;</span>:<span style="color: #BA2121">&quot;admin&quot;</span>,
            <span style="color: #008000; font-weight: bold">&quot;submittedlink&quot;</span>:<span style="color: #BA2121">&quot;https:\/\/imgur.com\/EwmGtqV&quot;</span>,
            <span style="color: #008000; font-weight: bold">&quot;scorefull&quot;</span>:<span style="color: #666666">124124</span>,
            <span style="color: #008000; font-weight: bold">&quot;links&quot;</span>:[
               <span style="color: #BA2121">&quot;https:\/\/i.imgur.com\/EwmGtqV.png&quot;</span>
            ]
         }
      ]
   }
}
</pre></div>






    <p class="h3">Getting the tanknames by ID</p>
    <p>To be able to properly map tank_id to tankname, you get send a GET request  <a
            href="{{route('apitanks')}}">here</a>.</p>
    <p>Example output:</p>
    <!-- HTML generated using hilite.me --><div style="background: #f8f8f8; overflow:auto;width:auto;border:solid gray;border-width:.1em .1em .1em .8em;padding:.2em .6em;margin-bottom:5em;"><pre style="margin: 0; line-height: 125%">[
   {
      <span style="color: #008000; font-weight: bold">&quot;id&quot;</span>:<span style="color: #666666">2</span>,
      <span style="color: #008000; font-weight: bold">&quot;tankname&quot;</span>:<span style="color: #BA2121">&quot;Annihilator&quot;</span>,
      <span style="color: #008000; font-weight: bold">&quot;enabled&quot;</span>:<span style="color: #666666">1</span>,
   },
   {
      <span style="color: #008000; font-weight: bold">&quot;id&quot;</span>:<span style="color: #666666">3</span>,
      <span style="color: #008000; font-weight: bold">&quot;tankname&quot;</span>:<span style="color: #BA2121">&quot;Assassin&quot;</span>,
      <span style="color: #008000; font-weight: bold">&quot;enabled&quot;</span>:<span style="color: #666666">1</span>,
   }
]
</pre></div>




    <p class="lead">Contact <a href="https://www.reddit.com/user/Schatterhand/">Me</a>, if you want access to an API to submit records.</p>



@endsection