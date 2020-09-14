@extends('layouts.app')

@section('title', 'Log - VeloLog')

@section('content')
            <div class="row">
                <div class="col-lg-3">
                    <form method="post" action="/logs/store">
                        @csrf
                        <select name="bike_id" id="bike-id" class="form-control" required>
                            <option value="" disabled selected>Select bike...</option>
                            @foreach ($bikes as $bike)
                            <option value="{{ $bike->id }}">{{ $bike->name }}</option>
                            @endforeach
                        </select>
                        <select name="type" class="form-control" required>
                            <option value="" disabled selected>Job type</option>
                            <option value="upgrade">Upgrade</option>
                            <option value="clean">Clean</option>
                            <option value="repair">Repair</option>
                            <option value="rebuild">Rebuild</option>
                        </select>
                        <select name="component" class="form-control">
                            <option value="" disabled selected>Component</option>
                            <option value="Bar ends">Bar ends</option>
                            <option value="Bearing">Bearing</option>
                            <option value="Belt-drive">Belt-drive</option>
                            <option value="Bike-whole">Bike (whole)</option>
                            <option value="Bottle cage">Bottle cage</option>
                            <option value="Bottom bracket">Bottom bracket</option>
                            <option value="Brake">Brake</option>
                            <option value="Brake lever">Brake lever</option>
                            <option value="Cassette">Cassette</option>
                            <option value="Chain">Chain</option>
                            <option value="Chainring">Chainring</option>
                            <option value="Chain tensioner">Chain tensioner</option>
                            <option value="Crankset">Crankset</option>
                            <option value="Derailleur hanger">Derailleur hanger</option>
                            <option value="Derailleur (front)">Derailleur (front)</option>
                            <option value="Derailleur (rear)">Derailleur (rear)</option>
                            <option value="Fork">Fork</option>
                            <option value="Gears">Gears</option>
                            <option value="Handlebar">Handlebar</option>
                            <option value="Handlebar tape">Handlebar tape</option>
                            <option value="Headset">Headset</option>
                            <option value="Inner tube">Inner tube</option>
                            <option value="Jockey wheel">Jockey wheel</option>
                            <option value="Pedal">Pedal</option>
                            <option value="Saddle">Saddle</option>
                            <option value="Seatpost">Seatpost</option>
                            <option value="Shifter">Shifter</option>
                            <option value="Stem">Stem</option>
                            <option value="Tyre">Tyre</option>
                            <option value="Wheel">Wheel</option>
                        </select>
                        <input class="form-control" type="number" placeholder="How far has the bike travelled" name="distance" id="distance" @if (!empty($distances)) {{ "readonly='readonly'" }} @endif required />
                        <textarea placeholder="Description of work carried out..." name="note" class="form-control"></textarea>
                        <select name="grease_monkey" class="form-control" required>
                            <option value="" disabled selected>Who did the work?</option>
                            <option value="self">Self</option>
                            <option value="friend">Friend</option>
                            <option value="professional">Professional</option>
                        </select>
                        <input class="form-control" type="submit" value="Record work" />
                    </form>
                    <hr class="my-4" />
                </div>
                <div class="col-lg-6">
                    <select name="filter-type" class="form-control col-lg-4 mr-2 float-left filter" id="filter-type">
                        <option value="" disabled selected>Filter job type</option>
                        <option value="">None</option>
                        <option value="upgrade">Upgrade</option>
                        <option value="clean">Clean</option>
                        <option value="repair">Repair</option>
                        <option value="rebuild">Rebuild</option>
                    </select>
                    <select name="filter-component" class="form-control col-lg-4 mr-2 filter float-left" id="filter-component">
                        <option value="" disabled selected>Filter component</option>
                        <option value="">None</option>
                        <option value="Bar ends">Bar ends</option>
                        <option value="Bearing">Bearing</option>
                        <option value="Belt-drive">Belt-drive</option>
                        <option value="Bike-whole">Bike (whole)</option>
                        <option value="Bottle cage">Bottle cage</option>
                        <option value="Bottom bracket">Bottom bracket</option>
                        <option value="Brake">Brake</option>
                        <option value="Brake lever">Brake lever</option>
                        <option value="Cassette">Cassette</option>
                        <option value="Chain">Chain</option>
                        <option value="Chainring">Chainring</option>
                        <option value="Chain tensioner">Chain tensioner</option>
                        <option value="Crankset">Crankset</option>
                        <option value="Derailleur hanger">Derailleur hanger</option>
                        <option value="Derailleur (front)">Derailleur (front)</option>
                        <option value="Derailleur (rear)">Derailleur (rear)</option>
                        <option value="Fork">Fork</option>
                        <option value="Gears">Gears</option>
                        <option value="Handlebar">Handlebar</option>
                        <option value="Handlebar tape">Handlebar tape</option>
                        <option value="Headset">Headset</option>
                        <option value="Inner tube">Inner tube</option>
                        <option value="Jockey wheel">Jockey wheel</option>
                        <option value="Pedal">Pedal</option>
                        <option value="Saddle">Saddle</option>
                        <option value="Seatpost">Seatpost</option>
                        <option value="Shifter">Shifter</option>
                        <option value="Stem">Stem</option>
                        <option value="Tyre">Tyre</option>
                        <option value="Wheel">Wheel</option>
                    </select>
                    <input type="text" readonly class="col-lg-3 form-control" id="distance-since-last" title="Distance since last" />
                    <div class="clearfix"></div>
                    <div id="cards">
                    @foreach ($logs as $log)
                        <div class="card bg-light mb-3 card-filter" data-job-type="{{ $log->type }}" data-component="{{ $log->component }}" data-distance="{{ $log->$units }}">
                            <div class="card-header">
                                {{ ucfirst($log->bike_name) }}
                                <form method="post" action="/logs/delete" class="float-right delete-log">
                                @csrf
                                    <input type="hidden" name="deleteid" value="{{ $log->id }}" />
                                    <input type="submit" class="close" aria-label="Close" value="&times;">
                                    </input>
                                </form>
                            </div>
                            <div class="card-body pb-2">
                                <h5 class="card-title">{{ ucfirst($log->type) }} 
                                    @if(!empty($log->component))
                                        ({{ lcfirst($log->component) }}) 
                                    @endif
                                    - {{ $log->$units }}{{ $units == 'metric' ? 'km' : 'mi' }}</h5>
                                <p>{{ mb_strimwidth($log->note, 0, 30, "...") }}</p>
                                <p class="text-right mb-0"><small>{{ $log->created_at }}</small></p>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>

            <script>
                $( document ).ready( function() {
                    var miles = {
                    @foreach ($distances as $distance)
                        {{ $distance->bike_id }} : "{{ $distance->$units }}",
                    @endforeach
                    };

                    $('#bike-id').on('change', function() {
                        $('#distance').val(miles[this.value]);
                    });

                    $('form.delete-log').submit(function(e){
                        e.preventDefault(); //Prevent the normal submission action
                        var form = this;
                        if (confirm('Are you sure you want to delete this')) {
                            form.submit();
                        }
                    });

                    $('.filter').on('change', function() {
                        var component = $("#filter-component").val();
                        var type = $("#filter-type").val();

                        $('#distance-since-last').val('');

                        // hide the card if it doesn't match any of the above
                        $('.card-filter').show();
                        $('.card-filter').each(function() {
                            hide_card($(this), component, type);
                        });

                        // update distance since last
                        if (component || type) {
                            show_distance_since();
                        }
                    });

                    // need to fix this so it doesn't break when first logging in
                    function show_distance_since() {
                        var last_distance = $('#cards').find('.card:visible:first').attr('data-distance');
                        if (last_distance) {
                            var current_distance = "{{ isset($distance->$units) ? $distance->$units : 0 }}";
                            $('#distance-since-last').val(current_distance - last_distance + "{{ $units == 'metric' ? 'km' : 'mi' }} since last");
                        }
                    }

                    function hide_card(card, component, type) {
                        if (!type && !component) {                  
                            card.show();
                        } else if (!type && component) {
                            if (card.attr('data-component') != component) {
                                card.hide();
                            }
                        } else if (type && !component) {
                            if (card.attr('data-job-type') != type) {
                                card.hide();
                            }
                        } else {
                            console.log(card.attr('data-job-type'), type);
                            console.log(card.attr('data-component'), component);
                            if (
                            card.attr('data-job-type') != type || 
                            card.attr('data-component') != component) {
                                card.hide();
                            }
                        }
                    }
                });
            </script>
@endsection
