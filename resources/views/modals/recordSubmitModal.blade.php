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
                {{-- Add a new world record form --}}
                <form action={{route('submitrecord')}} id="recordsubmit" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="inputname">Your name</label>
                        <input type="text" class="form-control" name="inputname" id="inputname" placeholder="Master OV"
                               maxlength="25" required>
                    </div>
                    <div class="form-group">
                        <label for="selectgamemode">The gamemode you played</label>
                        <select default="1" class="custom-select form-control" name="gamemode_id"
                                id="selectgamemode">
                            <optgroup label="Desktop">
                                @foreach ($gamemodesDesktop as $gamemode)
                                    <option value="{{$gamemode->id}}">{{$gamemode->name}}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="Mobile">
                                @foreach ($gamemodesMobile as $gamemode)
                                    <option value="{{$gamemode->id}}">{{$gamemode->name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="selectclass">The tank you used</label>
                        <select class="custom-select form-control selectpicker" name="selectclass"
                                id="selectclass">
                            @foreach ($tanknames as $tank)
                                <option data-icon="{{str_replace(" ","-",strtolower($tank->tankname))}}"
                                        value="{{$tank->id}}">{{$tank->tankname}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="score">Your Score</label>
                        <input type="number" class="form-control" name="score" id="score" placeholder="12345678"
                               min="40000" max="99999999" required>
                    </div>
                    <div class="form-group">
                        <label for="proof">Proof of your score</label>
                        <input type="url" class="form-control" name="proof" id="proof" required
                               placeholder="http://imgur.com/a/euVO7"
                               aria-describedby="urlHelpBlock">
                        <p id="urlHelpBlock" class="form-text text-muted">
                            <strong>ALL SUBMISSIONS MUST NOW BE FULL RECORDINGS (uploaded to youtube or another video site) OR
                            AN ALBUM OF SCREENSHOTS TAKEN AT VARIOUS INTERVALS ON THE ROAD TO A RECORD (e.g. one at 100K
                                200K, 300K, 400K, or further spaced apart if it is a bigger record).</strong>
                            <br>Only the following hosts are allowed: youtube, i.redd.it, imgur, discordapp, zippy.gfycat, i.gyazo.com
-                            or sX.postimg.

                        </p>
                    </div>
                    <button type="submit" id="recordsubmitbtn" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
