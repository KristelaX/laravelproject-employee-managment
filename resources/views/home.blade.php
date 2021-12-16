@extends('layouts.layout')

@section('content')

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                        <p>Admin</p><p>
                        We urge towards proactivity, and proactivity means being physically present whenever assistance is needed for domestic projects.

                        And there we are… located in one of the most attractive administrative areas of the Albanian capital, Tirana! You may find us at the best vicinity of the central business district, with rapid transit systems, full of dynamics and restlessness, and at the same time, just 3-minute walk away from the artificial lake of Tirana, the largest, open-air park of our metropolis.

                        Our location showcases the effectiveness and success of our products and services. Our modern and comprehensive premises are an added value to our enthusiasm and workflow.

                        Inspired by our internal eco-friendly policies, we make our employees and customers feel good, useful and inspired by working in comfortable and sustainable spaces.

                        Take a tour at our stunning glazed office micro-spaces. Our streamlined design features extended all-along, full of natural light and ventilation, make us a collaborative office and inspire cutting-edge creativity and innovation.
                    </p>


@endsection
