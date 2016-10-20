@extends('layouts.app')

@section('customstyle')

@endsection

@section('title', 'Diep.io World Records')

@section('content')

    @include('errors.common')

@section('leftnavitem')
    <button type="button" class="btn btn-primary btn-lg btn-diep diep-gradient-red" data-toggle="modal"
            data-target="#sbmrecord">Submit your record
    </button>
@endsection

<!-- Modal -->
<div class="modal fade" id="sbmrecord" tabindex="-1" role="dialog" aria-labelledby="sbmrecordlabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="sbmrecordlabel">Submit your record</h4>
            </div>
            <div class="modal-body">
                <!-- Add a new world record form -->
                <form action="/submitrecord" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="inputname">Your name</label>
                        <input type="text" class="form-control" name="inputname" id="inputname" required>
                    </div>
                    <div class="form-group">
                        <label for="selectgamemode">The gamemode you played</label>
                        <select default="1" class="custom-select form-control" name="gamemode_id"
                                id="selectgamemode">
                            @foreach ($gamemodes as $gamemode)
                                <option value="{{$gamemode->id}}">{{$gamemode->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="selectclass">The tank you used</label>
                        <select default="1" class="custom-select form-control" name="selectclass"
                                id="selectclass">
                            @foreach ($tanknames as $tank)
                                <option value="{{$tank->id}}">{{$tank->tankname}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="score">Your Score</label>
                        <input type="number" class="form-control" name="score" id="score" required>
                    </div>
                    <div class="form-group">
                        <label for="proof">Proof of your score</label>
                        <input type="url" class="form-control" name="proof" id="proof" required
                               pattern="(?:https?:\/\/)(?:www\.)?(?:youtube\.com|youtu\.be|cdn\.discordapp\.com|i\.redd\.it|i\.imgur\.com)(?:\/watch\\?v=([^&]+)|.*.png|.*.jpg)"
                               title="Link needs to be a https:// link, from youtube if video, or must be from one of the following sites and end with .jpg or .png: discordapp.com, reddit.com and imgur.com"
                               aria-describedby="urlHelpBlock">
                        <p id="urlHelpBlock" class="form-text text-muted">
                            Your proof must be a <strong>direct link</strong> to an image (or link to youtube.com). This
                            means <strong>for images the link must end in *.jpg or *.png</strong>
                            <br>Only the following hosts are allowed: youtube, reddit, imgur, discordapp.
                        </p>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="managerlogin" tabindex="-1" role="dialog" aria-labelledby="managerloginlabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="managerloginlabel">Login</h4>
            </div>
            <div class="modal-body">
                <!-- Add login for managers form -->
                <form action="/login" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="inputname">email:</label>
                        <input type="email" class="form-control" id="inputname" name="inputname">
                    </div>
                    <div class="form-group">
                        <label for="password">Pasword:</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>

            </div>
        </div>
    </div>
</div>


<p class="center diep-title">Diep.io World Records</p>

@if (session('status'))
    @foreach(session('status') as $status)
        <div class="alert {{$status->status}}">
            {{ $status->message }}
        </div>
    @endforeach
@endif


<div class="table-responsive">
    <table id="scoretable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Class</th>
            @foreach ($gamemodes as $gamemode)
                <th class="th{{$gamemode->name}}"
                    data-dynatable-sorts="sort{{str_replace("-","",strtolower($gamemode->name))}}">{{$gamemode->name}}</th>
                <th class="nodisplay">sort{{str_replace("-","",strtolower($gamemode->name))}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach ($allrecords as $recordsbytankid)
            <tr>
                <td><span class="tanksandname"><div
                                class="scoretanksimage {{str_replace(" ","-",strtolower($recordsbytankid[0]->tankname))}}"></div><span class="mobilehide">{{$recordsbytankid[0]->tankname}}</span></span>
                </td>
                <?php $pos = 0 ?>
                @foreach($gamemodes as $gamemode)
                    @if( isset($recordsbytankid[$pos]) and $recordsbytankid[$pos]->gamemode_id==$gamemode->id)
                        <td>
                            <a href="{{$recordsbytankid[$pos]->link}}" data-toggle="lightbox"><span
                                        class="tabletankscore">{{$recordsbytankid[$pos]->score}}</span> <span
                                        class="tabletankname mobilehide"><small>{{$recordsbytankid[$pos]->name}}</small></span></a>
                        </td>
                        <td>{{$recordsbytankid[$pos]->scorefull}}</td>
                        <?php  $pos++  ?>

                    @else
                        <td></td>
                        <td></td>
                    @endif
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
</div>


@endsection
@section('customscripts')
    <script>$(document).ready(function () {
            $('#scoretable').dynatable({
                table:{copyHeaderClass:true},
                readers: {
                    @foreach ($gamemodes as $gamemode)
                    'sort{{str_replace("-","",strtolower($gamemode->name))}}': function (el, record) {
                        return Number(el.innerHTML) || 0;
                    },
                    @endforeach
                }
            });
        });</script>
@endsection




