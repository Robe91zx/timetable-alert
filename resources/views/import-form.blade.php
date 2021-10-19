<!DOCTYPE html>
<html lang="en">
<head>
    <title>Import</title>
</head>
<body>
    <div>Import pichula</div>
    <form method="POST" enctype="multipart/form-data" action="{{route('subjects.import')}}"">
        @csrf
        <div class="form-group">
            <label for="file">Choose CSV</label>
            <input type="file" name="file">
        </div>
        <button type="submit" class="btn btn-primaty"   ></button>
    </form>
</body>    
</html>