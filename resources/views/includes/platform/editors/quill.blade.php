<div wire:ignore wire:key>

    @props(['id' => '', 'model' => null, 'class' => '', 'button' => 'publishBtn', 'uploadEndpoint' => '/slimdashboard/editor/image/adaptor', 'label' => ''])
    <div class="{{$class}}" x-data="{ content: @entangle($model).defer }">
        <label for="{{$id}}">{{$label}}</label>
        <div id="{{$id}}" style=""></div>
    </div>

    @push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>


        document.addEventListener('livewire:navigated', function () {
            var quill = new Quill('#{{$id}}', {
                theme: 'snow',
                placeholder: 'Type here...',
                modules: {
                    toolbar: [
                        [{ header: [1, 2, false] }],
                        ['bold', 'italic', 'underline'],
                        ['image', 'link'],
                        [{ list: 'ordered' }, { list: 'bullet' }]
                    ],
                    clipboard: {
                        matchers: [
                            ['IMG', function(node, delta) {
                                node.classList.add('quill-img'); // Add your custom class
                                return delta;
                            }]
                        ]
                    }
                }
            });

            quill.root.innerHTML = @this.get('{{$model}}');

            document.querySelector("#{{$button}}").addEventListener("click", () => {
                @this.set(@json($model), quill.root.innerHTML);
            });

            quill.getModule('toolbar').addHandler('image', () => {
                let input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.click();

                input.onchange = async () => {
                    let file = input.files[0];
                    if (file) {
                        let formData = new FormData();
                        formData.append('image', file);

                        // Upload Image using Livewire
                        let response = await fetch('{{$uploadEndpoint}}', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{csrf_token()}}'
                            }
                        });

                        let result = await response.json();

                        if (result.url) {
                            let range = quill.getSelection();
                            quill.insertEmbed(range.index, 'image', result.url);
                        }
                    }
                };
            });
        });
    </script>
    @endpush
</div>
