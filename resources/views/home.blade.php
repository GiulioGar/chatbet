@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <div class="row">
        <!-- Colonna Sinistra - Notizie -->
        <div class="col-lg-8">
            <div class="row">
                <!-- Primo Box Notizia -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <img class="card-img-top" src="news1.jpg" alt="News 1">
                        <div class="card-body">
                            <h5 class="card-title">The World Championship Results</h5>
                            <p class="card-text">
                                Universities and states are taking part in a campaign [...]
                            </p>
                            <a href="#" class="btn btn-primary">Read More</a>
                        </div>
                        <div class="card-footer text-muted">
                            <i class="fas fa-calendar-alt"></i> 10:10 am, December 5, 2016 |
                            <i class="fas fa-eye"></i> 1141 Views |
                            <i class="fas fa-comment"></i> 0 Comments
                        </div>
                    </div>
                </div>
                <!-- Secondo Box Notizia -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <img class="card-img-top" src="news2.jpg" alt="News 2">
                        <div class="card-body">
                            <h5 class="card-title">Golden Gloves of Season</h5>
                            <p class="card-text">
                                Our planet is really feeling the heat of Global Warming [...]
                            </p>
                            <a href="#" class="btn btn-primary">Read More</a>
                        </div>
                        <div class="card-footer text-muted">
                            <i class="fas fa-calendar-alt"></i> 9:59 am, December 5, 2016 |
                            <i class="fas fa-eye"></i> 642 Views |
                            <i class="fas fa-comment"></i> 0 Comments
                        </div>
                    </div>
                </div>
                <!-- Terzo Box Notizia -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <img class="card-img-top" src="news3.jpg" alt="News 3">
                        <div class="card-body">
                            <h5 class="card-title">Top Players of the League</h5>
                            <p class="card-text">
                                Yarbrough, born in Aguascalientes to Texan immigrants, was thrust [...]
                            </p>
                            <a href="#" class="btn btn-primary">Read More</a>
                        </div>
                        <div class="card-footer text-muted">
                            <i class="fas fa-calendar-alt"></i> 5:33 pm, November 30, 2016 |
                            <i class="fas fa-eye"></i> 572 Views |
                            <i class="fas fa-comment"></i> 0 Comments
                        </div>
                    </div>
                </div>
                <!-- Quarto Box Notizia -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <img class="card-img-top" src="news4.jpg" alt="News 4">
                        <div class="card-body">
                            <h5 class="card-title">The Most Insensitively Coach</h5>
                            <p class="card-text">
                                Ground round meatball landjaeger t-bone chicken beef ham hock [...]
                            </p>
                            <a href="#" class="btn btn-primary">Read More</a>
                        </div>
                        <div class="card-footer text-muted">
                            <i class="fas fa-calendar-alt"></i> 5:33 pm, November 30, 2016 |
                            <i class="fas fa-eye"></i> 653 Views |
                            <i class="fas fa-comment"></i> 1 Comment
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonna Destra - Info Varie -->
        <div class="col-lg-4">
            <!-- Next Match -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Next Match</h5>
                </div>
                <div class="card-body">
                    <p><strong>Man Utd</strong> vs <strong>Real Madrid</strong></p>
                    <p><i class="fas fa-calendar-alt"></i> August 15th, 2024</p>
                    <p><i class="fas fa-clock"></i> 6:10 pm</p>
                </div>
            </div>

            <!-- Top Matches -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Top Matches</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Germany 13-10 Portugal</li>
                    <li class="list-group-item">Real Madrid 10-9 Spain</li>
                    <li class="list-group-item">Spain 10-9 Portugal</li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Subscribe to our Newsletter</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="email">Your E-Mail ID</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter email">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </form>
                </div>
            </div>

            <!-- Club Points -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Club Points</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">1. Germany - 8 PTS</li>
                    <li class="list-group-item">2. Real Madrid - 10 PTS</li>
                    <li class="list-group-item">3. Spain - 8 PTS</li>
                    <li class="list-group-item">4. Portugal - 6 PTS</li>
                </ul>
            </div>
        </div>
    </div>
</div>


@endsection
