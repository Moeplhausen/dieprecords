<div class="table-responsive">
    <table id="bestsubmitterstable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>{{-- The first row shall consist of "Number", "Class" and "Score--}}
            <th class="submitterplace">Number</th>

            <th class="diep-gradient-yellow">Name</th>

            <th class="numberofrecords">Number Of World Records</th>
        </tr>
        </thead>
        <tbody>
        {{--
        --}}
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

            </tr>
        @endforeach
        </tbody>
    </table>
</div>