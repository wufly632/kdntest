<div>
    <template v-if="bannerEditShow">
        <div @click="shadowHidden"
             style="position: absolute;top: 0;left:0;right: 0;bottom:0;opacity: 0.6;height: 100%;background-color: #000000;z-index: 9998">
        </div>
        <div style="position: absolute;left: 40px;top:10%;right: 0;bottom: 10%;margin:0 30px 0 -10px;background-color:#FFFFff;z-index: 9999;max-height: 370px;overflow: auto">
            <form action="" class="form-horizontal" style="padding: 20px;">
                <label for="" style="margin-left:20px;">标题:</label>
                <input type="text" class="form-control my-form-control-sm"
                       style="width: 100px;">
                <label for="" style="margin-left:20px;">链接:</label>
                <input type="text" class="form-control my-form-control-sm">
                <input type="button" class="btn btn-success" value="保存">
                <input type="button" class="btn btn-danger" value="取消" @click="shadowHidden">
            </form>
        </div>
    </template>
    <div>
        <img :src="bannerPlaceholder"
             alt="" style="width: 100%;height: 600px;" @click="showBannerEdit">
    </div>
</div>