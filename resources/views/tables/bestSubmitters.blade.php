<div class="table-responsive">
    <table id="bestsubmitterstable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th class="submitterplace">Number</th>

            <th class="diep-gradient-yellow">Name</th>

            <th class="numberofrecords">Number Of World Records</th>

            <th class="max-score-records" data-dynatable-sorts="scorefull">Highest Score for current records</th>
            <th class="nodisplay">scorefull</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($bestSubmitters as $submitter)
            <tr>
                <td>
                    {{$submitter->row}}
                </td>

                <td>
                    {{$submitter->name}}
                </td>
                <td>
                    {{$submitter->numberOfRecords}}
                </td>
                <td>
                    <div class="tablebasicscore">{{$submitter->score}}</div>
                </td>
                <td class="nodisplay">
                    {{$submitter->scorefull}}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>