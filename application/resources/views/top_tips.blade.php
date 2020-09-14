@extends('layouts.app')

@section('title', 'Top Tips - VeloLog')

@section('content')
            <div class="row">
                <div class="col-3">
                    <div class="list-group" id="list-tab" role="tablist">
                        <a class="list-group-item list-group-item-action active" id="list-cleaning-list" data-toggle="list" href="#list-cleaning" role="tab" aria-controls="cleaning">Cleaning your bike</a>
                        <a class="list-group-item list-group-item-action" id="list-clean-chain-list" data-toggle="list" href="#list-clean-chain" role="tab" aria-controls="clean-chain">Cleaning your chain</a>
                        <a class="list-group-item list-group-item-action" id="list-indexing-list" data-toggle="list" href="#list-indexing" role="tab" aria-controls="indexing">Indexing your gears</a>
                        <a class="list-group-item list-group-item-action" id="list-punctures-list" data-toggle="list" href="#list-punctures" role="tab" aria-controls="punctures">Dealing with punctures</a>
                        <a class="list-group-item list-group-item-action" id="list-essentials-list" data-toggle="list" href="#list-essentials" role="tab" aria-controls="essentials">Essential tools</a>
                        <a class="list-group-item list-group-item-action" id="list-pre-ride-list" data-toggle="list" href="#list-pre-ride" role="tab" aria-controls="pre-ride">Pre ride check</a>
                    </div>
                    <hr class="my-4" />
                </div>
                <div class="col-6">
                    <div class="tab-content" id="nav-tabContent">

                        <div class="tab-pane fade show active" id="list-cleaning" role="tabpanel" aria-labelledby="list-cleaning-list">
                            <div class="card">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/5ak4AzlUz5Q">
                                    </iframe>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Cleaning your bike</h5>
                                    <p class="card-text">Cleaning your bike will keep the components in good working order making for a much smoother riding experience. It will also help you spot any issues that need addressing</p>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="list-clean-chain" role="tabpanel" aria-labelledby="list-clean-chain-list">
                            <div class="card">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/KM6mzE5lQ0w">
                                    </iframe>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Cleaning your Chain</h5>
                                    <p class="card-text">Your chain picks up dirt and grime from the road. This can get into the rollers and cause wear over time. A clean chain will give you better performance and you'll need to replace it less often. We recommend changing your chain every 3200 km/2000 mi</p>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="list-indexing" role="tabpanel" aria-labelledby="list-indexing-list">
                            <div class="card">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/Bbk5RcH0bbQ">
                                    </iframe>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Indexing your gears</h5>
                                    <p class="card-text">Gears not running smoothly? Noisy or jumping? Try adusting the indexing of your gears. It's super simple and makes life so much better on the bike!</p>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="list-punctures" role="tabpanel" aria-labelledby="list-punctures-list">
                            <div class="card">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/eqR6nlZNeU8">
                                    </iframe>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Punctures and changing tyres</h5>
                                    <p class="card-text">Punctures happen. It's a fact! But by following the above guide you'll be rolling again in no time.<br />
                                    If you see tears or slashes in your tyres it's time for new ones.</p>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="list-essentials" role="tabpanel" aria-labelledby="list-essentials-list">
                            <div class="card">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/4_nV3Qyn_vE">
                                    </iframe>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Essential Tools</h5>
                                    <p class="card-text">Here's a beginners guide to which tools you'll need to service your pride and joy</p>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="list-pre-ride" role="tabpanel" aria-labelledby="list-pre-ride-list">
                            <div class="card">
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/EBKeNOBwaVE">
                                    </iframe>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">Pre ride checks</h5>
                                    <p class="card-text">Things to look out for before you ride out</p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
@endsection
