<!doctype html>
<html lang="en">

<head>
    <title>All Author</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body>
    <header>
    </header>
    <main>

        <div class="container mt-3">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        @if (session('success'))
                            <div class="alert alert-success mt-3">{{ session('success') }}</div>
                        @endif
                        <div class="card-header d-flex justify-content-between">
                            <div class="header">
                                <h3>All Author</h3>
                            </div>
                            <div class="searh-input">
                                <input type="search" class="form-control" name="search" placeholder="Search" id="searchInput">
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">SL</th>
                                        <th scope="col">Author Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Photo</th>
                                        <th scope="col">Book Name</th>
                                        <th scope="col">View</th>
                                        <th scope="col">Update</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">
                                    @foreach ($students as $as => $student)
                                        <tr>
                                            <th scope="row">{{ $loop->index + 1 }}</th>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->email }}</td>
                                            <td>
                                                @if ($student->photo)
                                                    <img style="width: 50px; height: 50px;" src="{{ asset('uploads/students/' . $student->photo) }}" alt="">
                                                @else
                                                    <p>No Photo</p>
                                                @endif
                                            </td>
                                            <td>{{ $student->book_titles == '' ? 'No Book' : $student->book_titles }}</td>
                                            <td><a href="{{ route('authorView', $student->id) }}" class="btn btn-info">View</a></td>
                                            <td><a href="{{ route('updateStudent', $student->id) }}" class="btn btn-primary">Update</a></td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $users->links('pagination::bootstrap-5')}} --}}
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#searchInput').on('keyup',function(){
                var value=$(this).val();
                $.ajax({
                    // url:"{{ route('student.search') }}",
                    url: "{{ route('student.search') }}",
                    type: "GET",
                    data: { search: value },
                    success: function (student){
                        var html='';
                        if(student.length >0){
                            $.each(student,function(index, student){
                                html+="<tr>"
                                html+="<td>"+ (index+1)+"</td>"
                                html+="<td>"+ (student.name)+"</td>"
                                html+="<td>"+ (student.email)+"</td>"
                                if (student.photo) {
                                    html += `<td><img style="width:50px;height:50px" src="/uploads/students/${student.photo}" alt=""></td>`;
                                } else {
                                    html += "<td>No Photo</td>";
                                }
                                if (student.books.length > 0) {
                                    let booksHtml = '';
                                    student.books.forEach(function (book) {
                                        booksHtml += `<span class="badge bg-secondary me-1">${book.title}</span>`;
                                    });
                                    html += "<td>" + booksHtml + "</td>";
                                } else {
                                    html += "<td>No Book</td>";
                                }
                                html+="<td><a href='/view/" + student.id + "/author' class='btn btn-sm btn-info'> View </a></td>"
                                html+=`<td><a href='/student/edit/${student.id}' class='btn btn-sm btn-info'> Update </a></td>`
                                html+="</tr>"
                            })
                            $('#tbody').html(html);
                        }else{
                            html+="<tr>"
                            html+="<td colspan='7'>No Data Found</td>"
                            html+="</tr>"
                        }
                        $('#tbody').html(html);
                    },
                    error: function(xhr){
                        console.log("Error:",xhr.responseText);
                    }
                    
                });
            })
        })
    </script>
</body>

</html>