@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="profile">
            <div class="row">
                <div class="col-lg-4">

                    <upload-avatar :profile="{{ $profile }}" default-path="{{ $profile->avatarPath() }}"></upload-image>
                    <div class="profile__address"></div>
                    
                </div>
                <div class="col-lg-8">
                    <div class="profile__names">
                        <div class="profile__fullname">
                            <h3>{{ $profile->user->name }}</h3>
                            <div class="profile__location">
                                <i class="fas fa-map-marker-alt"></i>
                                <span class="profile__locationAddress">{{ $profile->address }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="profile__nickname">
                        <h5>{{ $profile->nickname }}</h5>
                    </div>
                    <div class="profileAbout">
                        <div class="profileAbout__title">
                            <i class="profileAbout__titleIcon fas fa-user"></i>
                            <span class="profileAbout__titleSpan">About</span>
                        </div>
                        <div class="profileAbout__description">
                            {{ $profile->description }}
                        </div>
                        <div class="contactInfo">
                            <div class="contactInfo__title">Contact information</div>
                            <div class="contactInfo__item">
                                <div class="contactInfo__name">Email</div>
                                <span class="contactInfo__email contactInfo__value">
                                    {{ $profile->user->email }}
                                </span>
                            </div>
                            <div class="contactInfo__item">
                                <div class="contactInfo__item">
                                    <div class="contactInfo__name">Phone</div>
                                    <a href="tel:+496170961709" class="contactInfo__value contactInfo__phone">{{ $profile->number }}</a>
                                </div>
                            </div>
                            <div class="contactInfo__item">
                                <div class="contactInfo__item">
                                    <div class="contactInfo__name">Sites</div>
                                    <ul class="contactInfo__sites contactInfo__value">
                                        @foreach ($profile->social_links as $key => $link)
                                            <li class="contactInfo__site">
                                                <a href="{{ $link['url'] }}">{{ $link['title'] }}</a>
                                                @if ($key !== count($profile->social_links) -1)
                                                    <span>,&nbsp;</span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="contactInfo__title">Basic information</div>
                            <div class="contactInfo__item">
                                <div class="contactInfo__item">
                                    <div class="contactInfo__name">Birthday</div>
                                    <div class="contactInfo__value contactInfo__birthday">{{ $profile->birthday }}</div>
                                </div>
                            </div>
                            <div class="contactInfo__item">
                                <div class="contactInfo__item">
                                    <div class="contactInfo__name">Gender</div>
                                    <div class="contactInfo__value contactInfo__gender">{{ $profile->gender }}</div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    
                </div>
                
                
            </div>
        </div>
    </div>
@endsection