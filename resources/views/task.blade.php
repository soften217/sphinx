@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Task</div>
                    <div class="panel-body">

                      <!-- New Task Form -->
                      <form action="/addtask" method="POST" class="form-horizontal">
                          {{ csrf_field() }}

                          <!-- Task Name -->
                          <div class="form-group">
                              <label for="task-name" class="col-sm-3 control-label">Task</label>

                              <div class="col-sm-6">
                                  <input type="text" name="task" id="task-name" class="form-control">
                              </div>
                          </div>

                          <!-- Add Task Button -->
                          <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-6">
                                  <button type="submit" class="btn btn-default">
                                      <i class="fa fa-plus"></i> Add Task
                                  </button>
                              </div>
                          </div>
                      </form>
                                                     <!-- Current Tasks -->
                            @if (count($tasktable) > 0)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Current Tasks
                                    </div>

                                    <div class="panel-body">
                                        <table class="table table-striped task-table">

                                            <!-- Table Headings -->
                                            <thead>
                                                <th>Task</th>
                                                <th>&nbsp;</th>
                                            </thead>

                                            <!-- Table Body -->
                                            <tbody>
                                                @foreach ($tasktable as $hello)
                                                    <tr>
                                                        <!-- Task Name -->
                                                        <td class="table-text">
                                                            <div>{{ $hello->task }}</div>
                                                        </td>
                                                        <td>
                                                            <a href='./deletetask/{{$hello->id}}'>DELETE</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                          @endif
                  </div>
            </div>
        </div>
    </div>
</div>

@endsection