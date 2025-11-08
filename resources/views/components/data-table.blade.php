<div class="table-responsive">
    <div id="expedientesTable">
        <table id="{{ $tableId }}" class="table table-hover table-bordered" style="width:100%">
            <thead>
                <tr>
                    @foreach($columns as $column)
                        <th class="{{ $column['class'] ?? '' }}">
                            {{ $column['label'] }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
    </div>
</div>