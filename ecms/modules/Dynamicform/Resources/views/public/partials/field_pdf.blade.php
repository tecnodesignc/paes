@if(isset($field->type))
    @switch($field->type)
        @case(7)
            <tr>
                <th scope="row">{{ $index }}</th>
                <td>{{$field->label}}</td>
                <td colspan="3" class="{{ isset($field->finding) ? 'text-danger' : 'text-secondary' }}">
                        @if(is_array($field->value))
                            {{ implode(', ', $field->value) }}
                        @else
                            {{ $field->value ?? null }}
                        @endif
                </td>
            </tr>

            @break
        @case(8)
        @case(9)
            <tr>
                <th scope="row">{{ $index }}</th>
                <td>{{$field->label}}</td>
                <td colspan="2" class="{{isset($field->finding) ? 'text-danger' : 'text-secondary'}}" >
                    @if(isset($field->value))
                        <a href="{{ url($field->value) }}" target="_blank">Ver imagen</a>
                    @else
                        {{ null }}
                    @endif
                </td>
                <td>{{$field->comment??''}}</td>
            </tr>
            @break

        {{-- Other fields  --}}
        @default
            <tr>
                <th scope="row">{{ $index }}</th>
                <td>{{ $field->label }}</td>
                <td class="{{ isset($field->finding) ? 'text-danger' : 'text-secondary' }}">
                    {{  $field->value ?? null }}
                </td>
                <td class="{{ isset($field->finding) ? 'text-danger' : 'text-secondary' }}">
                    @if(isset($field->image))
                        <a href="{{ url($field->image) }}" target="_blank">Ver imagen</a>
                    @else
                        {{ null }}
                    @endif
                </td>
                <td>{{ $field->comment ?? '' }}</td>
            </tr>
            @break

    @endswitch
@endif
