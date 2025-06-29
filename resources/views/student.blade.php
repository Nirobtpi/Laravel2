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
                        <div class="card-header">All Author</div>
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
                                <tbody>
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
                                            <td>{{ $student->book_titles ==''? 'No Book': $student->book_titles }}</td>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
</body>

</html>