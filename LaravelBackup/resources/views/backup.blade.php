@extends('laravellayout::layouts.admin')

 

@section('header')
    <section class="container-fluid">
      <h2>
        <span class="text-capitalize">Backup Database</span>
      </h2>
    </section>
@endsection

@section('content')
<!-- Default box -->
  <a id="create-new-backup-button" href="{{ route('backup.create') }}" class="btn btn-primary ladda-button mb-2" data-style="zoom-in"><span class="ladda-label"><i class="la la-plus"></i>Create New Backup</span></a>
  <div class="card">
    <div class="card-body p-0">
      <table class="table table-hover pb-0 mb-0">
        <thead>
          <tr>
            <th>#</th>
            <th>Location</th>
            <th>Date Add</th>
            <th class="text-right">Fize Size</th>
            <th class="text-right">Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($backups as $k => $b)
          <tr>
            <th scope="row">{{ $k+1 }}</th>
            <td>{{ $b['disk'] }}</td>
            <td>{{ \Carbon\Carbon::createFromTimeStamp($b['last_modified'])->formatLocalized('%d %B %Y, %H:%M') }}</td>
            <td class="text-right">{{ round((int)$b['file_size']/1048576, 3).' MB' }}</td>
            <td class="text-right">
                @if ($b['download'])
                <a class="btn btn-sm btn-link" href="{{ route('backup.download',['disk'=>$b['disk'],'file_name'=>$b['file_name']]) }}"><i class="fa fa-download" aria-hidden="true"></i> Download</a>
                @endif
                <a class="btn btn-sm btn-link" data-button-type="delete" href="{{ route('backup.delete',['disk'=>$b['disk'],'file_name'=>$b['file_name']]) }}"><i class="fa fa-window-close" aria-hidden="true"></i> Delete</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

    </div><!-- /.box-body -->
  </div><!-- /.box -->

@endsection

@section('after_scripts')

<script>
  jQuery(document).ready(function($) {
    // capture the Create new backup button
    $("#create-new-backup-button").click(function(e) {
        e.preventDefault();
        var create_backup_url = $(this).attr('href');
        // do the backup through ajax
        $.ajax({
            url: create_backup_url,
            type: 'PUT',
            success: function(result) {
                // Show an alert with the result
                if (result.indexOf('failed') >= 0) {
                    new Noty({
                        text: "<strong>{{ trans('laravelbackup::backup.create_warning_title') }}</strong><br>{{ trans('laravelbackup::backup.create_warning_message') }}",
                        type: "warning"
                    }).show();
                }
                else
                {
                    new Noty({
                        text: "<strong>{{ trans('laravelbackup::backup.create_confirmation_title') }}</strong><br>{{ trans('laravelbackup::backup.create_confirmation_message') }}",
                        type: "success"
                    }).show();
                }
            },
            error: function(result) {
                // Show an alert with the result
                new Noty({
                    text: "<strong>{{ trans('laravelbackup::backup.create_error_title') }}</strong><br>{{ trans('laravelbackup::backup.create_error_message') }}",
                    type: "warning"
                }).show();
            }
        });
    });
    // capture the delete button
    $("[data-button-type=delete]").click(function(e) {
        e.preventDefault();
        var delete_button = $(this);
        var delete_url = $(this).attr('href');
        if (confirm("{{ trans('laravelbackup::backup.delete_confirm') }}") == true) {
            $.ajax({
                url: delete_url,
                type: 'DELETE',
                success: function(result) {
                    // Show an alert with the result
                    new Noty({
                        text: "<strong>{{ trans('laravelbackup::backup.delete_confirmation_title') }}</strong><br>{{ trans('laravelbackup::backup.delete_confirmation_message') }}",
                        type: "success"
                    }).show();
                    // delete the row from the table
                    delete_button.parentsUntil('tr').parent().remove();
                },
                error: function(result) {
                    // Show an alert with the result
                    new Noty({
                        text: "<strong>{{ trans('laravelbackup::backup.delete_error_title') }}</strong><br>{{ trans('laravelbackup::backup.delete_error_message') }}",
                        type: "warning"
                    }).show();
                }
            });
        } else {
            new Noty({
                text: "<strong>{{ trans('laravelbackup::backup.delete_cancel_title') }}</strong><br>{{ trans('laravelbackup::backup.delete_cancel_message') }}",
                type: "info"
            }).show();
        }
      });
  });
</script>
@endsection