@csrf

<div class="form-group">
    <label for="question-title">Question Title</label>
    <input type="text" value="{{ old('title', $question->title) }}" name="title" id="question-title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">

    @if ($errors->has('title'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('title') }}</strong>
    </div>
    @endif
</div>

<div class="form-group">
    <label for="question-body">Write your question</label>
    <textarea name="body" class="form-control {{ $errors->has('body') ? 'is-invalid' : '' }}" id="question-body" rows="10">{{ old('body', $question->body) }}</textarea>

    @if ($errors->has('body'))
    <div class="invalid-feedback">
        <strong>{{ $errors->first('body') }}</strong>
    </div>
    @endif

</div>

<div class="form-group">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>