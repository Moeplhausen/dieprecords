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
    <input type="text" class="form-control" name="inputname" id="inputname" maxlength="32" required>
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