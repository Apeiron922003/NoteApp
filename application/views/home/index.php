<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!-- Add Note form -->
<?php require_once (APPPATH . 'views/home/addNodeForm.php'); ?>

<div class="mx-auto container py-20 px-6">
    <!-- Add Note Button-->
    <div>
        <button class="w-32 mb-3 font-bold py-2 px-4 rounded bg-blue-500 text-white hover:bg-blue-700 cursor-pointer"
            onclick="addNoteFormToggle(true)">+ Add
            note</button>
    </div>
    <!-- Note List Container-->
    <div class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-6">
        <?php if (!empty($notes)): ?>
            <!-- Note List -->
            <?php foreach ($notes as $note): ?>

                <form data-id="<?php echo $note->id ?>" action="<?php echo site_url("home/update_note"); ?>" method="POST"
                    class="note w-full h-64 flex flex-col justify-between bg-white rounded-lg border border-gray-400 mb-6 py-5 px-4 relative">
                    <!-- Header Note -->
                    <div>
                        <input name="title" class="note-title text-gray-800 font-bold mb-3 outline-none px-3 py-1 w-full"
                            value="<?php echo $note->title ?>" readonly></input>
                        <textarea name="content"
                            class="note-content text-gray-800 text-sm w-full h-full select-none outline-none resize-none px-3 py-1"
                            readonly><?php echo $note->content ?></textarea>
                    </div>
                    <!-- Footer Note-->
                    <div class="px-3 py-1">
                        <div class="flex items-center justify-between text-gray-800">
                            <p class="note-date text-sm"><?php echo $note->created_at ?></p>
                            <button
                                class="edit-note-btn w-8 h-8 rounded-full bg-gray-800 hover:bg-gray-700 d text-white flex items-center justify-center"
                                aria-label="edit note" role="button">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Close Note-->
                    <a href="<?php echo site_url("home/delete_note/{$note->id}"); ?>"
                        onclick="return confirm('Delete <?php echo $note->title ?> ?');"
                        class="delete-note-btn absolute -top-2 right-1 text-2xl text-gray-500 hover:text-red-500 focus:outline-none focus:text-black-800"
                        aria-label="delete note" role="button">
                        ×
                    </a>
                </form>

            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-gray-600">No notes found.</p>
        <?php endif; ?>
    </div>
</div>
<script>
    const noteList = document.querySelectorAll(".note");
    const noteTitle = (note) => note.querySelector(".note-title");
    const noteContent = (note) => note.querySelector(".note-content");
    const editNoteBtn = (note) => note.querySelector(".edit-note-btn");
    function applyStyles(element, styles) {
        Object.assign(element.style, styles);
    }

    function removeStyles(element, styles) {
        for (let property in styles) {
            element.style[property] = '';
        }
    }

    function editChangeState(note, state) {
        const styleEdit = {
            borderWidth: '2px',
            borderColor: 'black',
            borderStyle: 'solid',
            borderRadius: '0.25rem'
        };

        if (state) {
            noteTitle(note).removeAttribute("readonly");
            noteContent(note).removeAttribute("readonly");
            applyStyles(noteTitle(note), styleEdit);
            applyStyles(noteContent(note), styleEdit);
        } else {
            noteTitle(note).setAttribute("readonly", "true");
            noteContent(note).setAttribute("readonly", "true");
            removeStyles(noteTitle(note), styleEdit);
            removeStyles(noteContent(note), styleEdit);
        }
    }


    noteList.forEach(note => {

        // Change State
        editNoteBtn(note).addEventListener("click", (e) => {
            const isEdit = !note.querySelector(".note-content").hasAttribute("readonly");
            // Change Style
            editChangeState(note, !isEdit);

            // Change Icon
            if (isEdit) {
                editNoteBtn(note).classList.remove("bg-green-500", "hover:bg-green-700");
                editNoteBtn(note).classList.add("bg-gray-800", "hover:bg-gray-700");
                editNoteBtn(note).innerHTML = '<i class="fa-solid fa-pen"></i>';
                editNoteBtn(note).setAttribute("type", "submit");
            } else {
                editNoteBtn(note).classList.remove("bg-gray-800", "hover:bg-gray-700");
                editNoteBtn(note).classList.add("bg-green-500", "hover:bg-green-700");
                editNoteBtn(note).innerHTML = '<i class="fa-solid fa-check"></i>';
                editNoteBtn(note).setAttribute("type", "button");
            }
        })

        // submit update
        note.addEventListener("submit", (e) => {
            e.preventDefault();
            const id = e.target.dataset.id;
            const title = noteTitle(note).value;
            const content = noteContent(note).value
            const data = { id, title, content };
            fetch(e.target.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    alert('Update Sucessful!')
                    // console.log('Response from server:', data);
                })
                .catch(error => {
                    alert('Update Failure!')
                    // console.error('Error sending data to server:', error);
                });

        })
    });
</script>