import React from 'react';
import {useForm} from "@inertiajs/react";
import Select from 'react-select';
import DangerButton from "@/Components/DangerButton.jsx";

/**
 * useForm()にtodoを渡して初期化
 * <Select />に必要な情報を入れる
 *      optionsはセレクトボックスの選択肢。
 *      onChangeで変更されたらupdateが呼ばれる
 * update内でdataの値を書き換えて、todo.updateに処理を投げる。
 *      dataの書き換えにsetDataをお使用すると非同期なのでpatch()が書き換え前の値で処理される
 *      ->data.progress=e.valueで直接書き換え
 * todo.title <p>タグのclassNameを進捗が完了に代わると取り消し線が表示される。
 * 
 * deleteはjavascript自体の予約語->destroy
 * 削除用のボタン:destroySubmit
 */
export default function Todo({ todo }) {

    const {data, setData, patch, delete: destroy, processing} = useForm(todo);

    const update = (e) => {
        data.progress = e.value;
        patch(route('todo.update', todo.id));
    }

    const destroySubmit = (e) => {
        e.preventDefault();
        destroy(route('todo.destroy', todo.id));
    };

    const options = [
        { value: 0, label: '未着手'},
        { value: 1, label: '進行中'},
        { value: 2, label: '完了　'},
    ]

    return (
        <div className="flex mb-3 items-center">
            <p className={`w-7/12 ${data.progress === 2 && "line-through"}`}>
                {todo.title}
            </p>

            <Select
                className="mx-2 w-3/12"
                options={options}
                defaultValue={options[data.progress]}
                onChange={update}
            />

            <form onSubmit={destroySubmit} className="w-2/12">
                <DangerButton className="" disabled={processing}>Delete</DangerButton>
            </form>
        </div>
    );
}