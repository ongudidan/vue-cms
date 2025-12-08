@foreach($board_members as $key => $member)
<div class="col-lg-3 col-sm-6">
   <div class="component-card">
      <div class="component-card-img">
         <img class="img-fluid" src="{{ $member->media[0]->original_url ?? asset('website/dummy_450x450.jpg') }}" alt="image">
      </div>
      <div class="component-card-text-2">
         <h5 class="fw-bold mb-0">{{ $member->name }}</h5>
         <p class="mb-0 fs-13 text-muted">{{ $member->position }}</p>
      </div>
   </div>
</div>
@endforeach
