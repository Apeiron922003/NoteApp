<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="addNote-form fixed z-10 top-0 left-0 flex items-start justify-center h-full w-screen">
    <div class="addNote-overlay absolute z-11 top-0 left-0 bottom-0 right-0 bg-black opacity-70"></div>
    <div class="max-w-md w-96 mx-auto bg-white p-6 rounded-lg shadow-md mt-10 relative z-12">
        <h2 class="text-2xl mb-4 font-bold">Thêm Ghi Chú Mới</h2>
        <?php echo form_open('home/add_note'); ?>
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-bold mb-2">Tiêu Đề:</label>
            <input type="text" id="title" name="title" placeholder="Nhập tiêu đề..." required
                class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-6">
            <label for="content" class="block text-gray-700 font-bold mb-2">Nội Dung:</label>
            <textarea id="content" name="content" rows="6" placeholder="Nhập nội dung..." required
                class="appearance-none border rounded-md w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit"
                class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Lưu Ghi Chú
            </button>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script>
    const addNoteOverlay = document.querySelector(".addNote-overlay");
    const addNoteForm = document.querySelector(".addNote-form")

    function addNoteFormToggle(status) {
        addNoteForm.style.display = status ? "flex" : "none"
    }
    addNoteFormToggle(false)

    addNoteOverlay.addEventListener("click", () => {
        addNoteFormToggle(false)
    })


</script>