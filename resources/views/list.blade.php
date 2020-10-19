<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajax TODO List Project</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" integrity="sha512-aOG0c6nPNzGk+5zjwyJaoRUgCdOrfSDhmMID2u4+OIslr0GjpLKo7Xm0Ao3xmpM4T8AmIouRkqwj1nrdVsLKEQ==" crossorigin="anonymous" />
    
  </head>
<body>
<br>
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-3 col-lg-6"></div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Ajax Todo List <a href="#" class="pull-right" id="addNew" data-toggle="modal" data-target="#myModal"> <i class="fa fa-plus" aria-hidden="true"></i><a></h3>
                </div>
                <div class="panel-body" id="todos">
                    <ul class="list-group">
                      @foreach ($todos as $todo)
                      <li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal">{{$todo->todo}}
                        <input type="hidden" id="todoId" value="{{$todo->id}}">
                      </li>                         
                       
                      @endforeach
                        {{-- <li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal">Learn Pytorch</li>
                        <li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal">Open Source Project</li>
                        <li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal">Build Portfolio</li>
                        <li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal">Learn Ajax</li>
                        <li class="list-group-item ourItem" data-toggle="modal" data-target="#myModal">Learn React</li> --}}
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-2">
          <input type="text" class="form-control" name="todo" id="searchTodo" placeholder="Search">
        </div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="title">Add New To-do</h4>
                </div>
                <div class="modal-body">
                  <input type="hidden" id="id">
                  <p><input type="text" placeholder="Add Item Here" id="addItem" class="form-control"></p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-warning" id="delete" data-dismiss="modal" style="display: none">Delete</button>
                  <button type="button" class="btn btn-primary" id="saveChanges" data-dismiss="modal" style="display: none">Save changes</button>
                  <button type="button" class="btn btn-primary" id="AddButton" data-dismiss="modal">Add To-do</button>
                </div>
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal -->
    </div>
    {{csrf_field()}}
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" integrity="sha512-uto9mlQzrs59VwILcLiRYeLKPPbS/bT71da/OEBYEwcdNUk8jYIy+D176RYoop1Da+f9mvkYrmj5MCLZWEtQuA==" crossorigin="anonymous"></script>
    <script>
      $(document).ready(function(){
        $(document).on('click', '.ourItem', function(event){
                var text = $(this).text();
                var id = $(this).find('#todoId').val();
                $('#title').text('Edit Item')
                var text = $.trim(text);
                $('#addItem').val(text);
                $('#delete').show('400');
                $('#saveChanges').show('400');
                $('#AddButton').hide('400');
                $('#id').val(id);
                console.log(text);
        });

        $(document).on('click', '#addNew', function(event){
            $('#title').text('Add New To-do')
            $('#addItem').val("");
            $('#delete').hide('400');
            $('#saveChanges').hide('400');
            $('#AddButton').show('400')
        });

        $('#AddButton').click(function(event){
          var text = $('#addItem').val();
          if(text == "") {
            alert('Please enter a todo')
          } else{
            $.post('list', {'text': text,'_token':$('input[name=_token]').val()}, 
          function (data) {
            $('#todos').load(location.href + ' #todos');
            console.log(data);              
          });
          }
        })

        $('#delete').click(function(event){
          var id = $('#id').val()
          $.post('delete', {'id': id,'_token':$('input[name=_token]').val()}, 
          function (data) {
            $('#todos').load(location.href + ' #todos');
            console.log(data);
          });
        });


        $('#saveChanges').click(function(event){
          var id = $('#id').val();
          var value =  $('#addItem').val();
          $.post('update', {'id': id,'value': value,'_token':$('input[name=_token]').val()}, 
          function (data) {
            $('#todos').load(location.href + ' #todos');
            console.log(data);
          });
        });
        $( function() {
          var availableTags = [
            "ActionScript",
            "AppleScript",
            "Asp",
            "BASIC",
            "C",
            "C++",
            "Clojure",
            "COBOL",
            "ColdFusion",
            "Erlang",
            "Fortran",
            "Groovy",
            "Haskell",
            "Java",
            "JavaScript",
            "Lisp",
            "Perl",
            "PHP",
            "Python",
            "Ruby",
            "Scala",
            "Scheme"
          ];
          $( "#searchTodo" ).autocomplete({
            source: 'http://localhost/ajax-todoapp/public/search'
          });
        });
      });
    </script>
</body>
</html>