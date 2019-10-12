<template>
    <div>
        <div class="form-group">
            <label>ФИО</label>
            <input type="text" class="form-control" name="full_name">
        </div>

        <div class="form-group">
            <label>Дата рождения</label>
            <input type="date" class="form-control" name="birthday_date">
        </div>

        <div class="form-group">
            <label>Организация</label>
            <input type="text" class="form-control" name="organization">
        </div>

        <div class="form-group">
            <label>Тип пользователя</label>
            <select class="form-control" v-model="f" name="user_type_id">
                <option value="">нет</option>
                <option :value="key" v-for="(value, key) in UserTypeArr">
                    {{value}}
                </option>
            </select>
        </div>

        <div class="form-group">
            <label>Блок с чекбоксами</label>
            <ul>
                <li v-for="(value, key) in checkboxArr[f]">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" :id="'check'+key" v-model="value.checked"
                               :name="'role['+value.id+']'">
                        <label class="form-check-label" :for="'check'+key">{{value.title}}</label>
                    </div>
                </li>
            </ul>
        </div>
        <a href="/" class="btn btn-light">Назад</a>
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</template>

<script>
    export default {
        props: [
            'checkbox_arr',
            'user_type_arr',
        ],
        mounted() {

        },
        data: function () {

            return {
                f: '',
                checkboxArr: this.checkbox_arr,
                UserTypeArr: this.user_type_arr,
            }
        }
    };
</script>
