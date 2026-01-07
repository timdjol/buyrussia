<div class="table-wrap">
    <table>
        <thead>
        <tr>
            <th>번호</th>
            <th>제목</th>
            <th>작성자</th>
            <th>작성일</th>
        </tr>
        </thead>
        <tbody>
        @foreach($ads as $ad)
            <tr>
                <td>{{ $ad->id }}</td>
                <td>
                    @isset($ad->region_id)
                        <div class="stick reg">
                            <a href="{{ route('taglist', $ad->region_id) }}">{{ $ad->region->title }}</a>
                        </div>
                    @endisset
                    @isset($ad->company_id)
                        <div class="stick comp">
                            <a href="{{ route('taglist', $ad->company_id) }}">{{ $ad->company->title }}</a>
                        </div>
                    @endisset
                    <a href="{{ route('post', $ad->id) }}">{{ $ad->title }}</a>
                </td>
                <td style="font-size: 14px">{{ $ad->user->name }}</td>
                <td><div class="date">{{ $ad->created_at->format('d M Y') }}</div></td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="row aic">
        <div class="col-md-10">
            {{ $ads->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
        </div>
        <div class="col-md-2">
            <div class="btn-wrap">
                <a href="{{ route('createAd') }}" class="more">추가하다</a>
            </div>
        </div>
    </div>
</div>
