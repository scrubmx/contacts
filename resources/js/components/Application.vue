<template>
    <form @submit.prevent="onSubmit" class="px-5" enctype="multipart/form-data">
        <section>
            <h2 class="flex items-center mb-3 text-90 font-normal text-2xl">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M6 2h9a1 1 0 0 1 .7.3l4 4a1 1 0 0 1 .3.7v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4c0-1.1.9-2 2-2zm9 2.41V7h2.59L15 4.41zM18 9h-3a2 2 0 0 1-2-2V4H6v16h12V9z"/>
                </svg>
                <span class="ml-2">Import contacts from a spreadsheet</span>
            </h2>
            <p class="text-90 leading-tight mb-8">
                Here you can import your contacts to the database
            </p>
            <div class="rounded shadow overflow-hidden sm:w-2/3 w-full mb-12">
                <div class="bg-white p-6">
                    <label for="document" class="block text-gray-700 text-sm font-bold mb-2">Import contacts from a spreadsheet</label>
                    <input type="file" id="document" name="document" @change="handleFile" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    <p class="mt-4 text-xs font-italic text-gray-500">
                        File must be:
                        <code class="d-inline-block">CSV</code>,
                        <code class="d-inline-block">XLS</code>,
                        <code class="d-inline-block">XLSX</code>,
                        or
                        <code class="d-inline-block">ODS</code>,
                    </p>
                </div>
            </div>
        </section>

        <section v-if="fileHeaders.length">
            <h2 class="flex items-center mb-3 text-90 font-normal text-2xl">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M13 5.41V17a1 1 0 01-2 0V5.41l-3.3 3.3a1 1 0 01-1.4-1.42l5-5a1 1 0 011.4 0l5 5a1 1 0 11-1.4 1.42L13 5.4zM3 17a1 1 0 012 0v3h14v-3a1 1 0 012 0v3a2 2 0 01-2 2H5a2 2 0 01-2-2v-3z"/>
                </svg>
                <span class="ml-2">Import field mapping</span>
            </h2>
            <p class="text-90 mb-3 leading-tight">
                Here you can map your custom headers to the database columns
            </p>
            <p class="bg-blue-100 border rounded text-blue-600 p-4 mb-6 mt-2 sm:w-2/3 w-full">
                <svg class="w-5 h-5 mr-1 -mt-1 inline-block" viewBox="0 0 20 20">
                    <g stroke="currentColor" stroke-width="1" fill="currentColor" fill-rule="evenodd">
                        <path d="M2.92893219,17.0710678 C6.83417511,20.9763107 13.1658249,20.9763107 17.0710678,17.0710678 C20.9763107,13.1658249 20.9763107,6.83417511 17.0710678,2.92893219 C13.1658249,-0.976310729 6.83417511,-0.976310729 2.92893219,2.92893219 C-0.976310729,6.83417511 -0.976310729,13.1658249 2.92893219,17.0710678 L2.92893219,17.0710678 Z M15.6568542,15.6568542 C18.7810486,12.5326599 18.7810486,7.46734008 15.6568542,4.34314575 C12.5326599,1.21895142 7.46734008,1.21895142 4.34314575,4.34314575 C1.21895142,7.46734008 1.21895142,12.5326599 4.34314575,15.6568542 C7.46734008,18.7810486 12.5326599,18.7810486 15.6568542,15.6568542 Z M9,11 L9,10.5 L9,9 L11,9 L11,15 L9,15 L9,11 Z M9,5 L11,5 L11,7 L9,7 L9,5 Z" />
                    </g>
                </svg>
                Fields <span class="font-bold">phone</span> and <span class="font-bold">team_id</span> are required.
            </p>
            <div class="rounded shadow overflow-hidden sm:w-2/3 w-full mb-12">
                <div class="bg-white">
                    <div class="overflow-scroll">
                        <table class="w-full" style="min-width: 580px">
                            <thead class="bg-gray-300">
                            <tr class="text-gray-600 text-xs font-semibold uppercase tracking-wider border-gray-300 border-b">
                                <th class="font-light font-semibold py-3">File Headers</th>
                                <th class="font-light font-semibold py-3">Table Target Fields</th>
                            </tr>
                            </thead>
                            <tbody class="text-sm tracking-normal">
                                <tr v-for="(dbColumn, key) in dbColumns" class="border-gray-300 border-b border-t">
                                    <td class="py-3 px-5 border-r">
                                        <select :name="`columns[${dbColumn}]`" v-if="fileHeaders[key]">
                                            <option selected disabled>&mdash;</option>
                                            <option v-for="fileHeader in fileHeaders" :value="fileHeader" :selected="similarStrings(fileHeader, dbColumn)">{{ fileHeader }}</option>
                                        </select>
                                        <select :name="`columns[${dbColumn}]`" v-else>
                                            <option selected disabled>&mdash;</option>
                                            <option v-for="fileHeader in fileHeaders" :value="fileHeader">{{ fileHeader }}</option>
                                        </select>
                                    </td>
                                    <td class="py-3 px-5">{{ dbColumn }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="bg-gray-300 p-6 py-4">
                    <div class="ml-auto flex align-center justify-end">
                        <button @click.prevent="clearForm" class="hover:bg-gray-300 py-1 px-4 rounded focus:outline-none focus:shadow-outline">Cancel</button>
                        <button type="submit" class="ml-3 shadow bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded focus:outline-none focus:shadow-outline">
                            Import
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </form>
</template>

<script>
import XLSX from 'xlsx';
import swal from 'sweetalert';
import stringSimilarity from 'string-similarity';

export default {
    data() {
        return {
            columns: [],
            loading: false,
            dbColumns: [],
            fileName: '',
            fileHeaders: [],
            fileRows: [],
            selectedFields: [],
        };
    },

    mounted() {
        axios.get('/api/contacts/fields')
             .then((response) => this.dbColumns = response.data.data);
    },

    methods: {
        handleFile(event) {
            this.clearForm();

            let files = event.target.files,
                file = files[0];

            let reader = new FileReader();

            reader.onload = (event) => {
                let data = new Uint8Array(event.target.result);
                let workbook = XLSX.read(data, { type: 'array' });

                // Grab the first "worksheet" and assume first row are header names.
                let first_worksheet = workbook.Sheets[workbook.SheetNames[0]];
                let json = XLSX.utils.sheet_to_json(first_worksheet, { header: 1 });

                this.fileName = file.name;
                this.fileHeaders = json.shift();
                this.fileRows = json;
            };

            reader.readAsArrayBuffer(file);
        },

        onSubmit(event) {
            this.loading = true;

            let formData = new FormData(event.target);
            formData.append('extra', JSON.stringify(this.extraFields()));

            axios.post('/contacts', formData)
                 .then((response) => swal('Éxito', 'Se guardaron tus contactos correctamente.', 'success'))
                 .catch((error) => console.log(error.response.data))
                 .finally(() => this.loading = false)
        },

        clearForm() {
            this.fileName = '';
            this.fileHeaders = [];
            this.fileRows = [];
        },

        extraFields() {
            let selects = document.querySelectorAll('select[name^="columns"');

            selects.forEach((el) => this.selectedFields.push(el.value));

            return this.fileHeaders.filter((header) => ! this.selectedFields.includes(header));
        },

        similarStrings(fileHeader, dbColumn) {
            let search = fileHeader.trim()
                .toLowerCase()
                .replace(' ', '_')
                .replace(/['"]+/g, '');

            return stringSimilarity.compareTwoStrings(search, dbColumn) >= 0.4;
        },
    },
};
</script>
